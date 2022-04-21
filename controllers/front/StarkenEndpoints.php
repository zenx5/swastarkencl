<?php
/**
 *  NOTICE OF LICENSE
 *
 *  This product is licensed for one customer to use on one installation (test stores and multishop included).
 *  Site developer has the right to modify this module to suit their needs, but can not redistribute the module
 *  in whole or in part. Any other use of this module constitues a violation of the user agreement.
 *
 *  DISCLAIMER
 *
 *  NO WARRANTIES OF DATA SAFETY OR MODULE SECURITY ARE EXPRESSED OR IMPLIED. USE THIS MODULE IN ACCORDANCE WITH
 *  YOUR MERCHANT AGREEMENT, KNOWING THAT VIOLATIONS OF PCI COMPLIANCY OR A DATA BREACH CAN COST THOUSANDS OF
 *  DOLLARS IN FINES AND DAMAGE A STORES REPUTATION. USE AT YOUR OWN RISK.
 *
 * @author    Software Agil Ltda
 * @copyright 2021
 * @license   See above
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class SwastarkenclStarkenEndpointsModuleFrontController extends ModuleFrontController
{
    public function __construct()
    {
        parent::__construct();
        $this->ajax = true;
    }
    
    public function postProcess()
    {
        if (!Tools::getValue('token') || Tools::getValue('token') != Configuration::get('SWASTARKENCL_TOKEN')) {
            header('Content-Type: text/json; charset=utf-8');
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(
                [
                    'ErrorMessage' => $this->module->l(
                        'You must enter a valid token to access this resource',
                        'starkenendpoints'
                    )
                ]
            );
        } else {
            // Check if input "check_carrier_id" is a payment on arrival shipping option
            if (Tools::isSubmit('check_carrier_id')) {
                $paymentType = SwastarkenclCarrier::getPaymentTypeByCarrierId(Tools::getValue('check_carrier_id'));
                if ($paymentType['payment_type'] == 3) {
                    echo json_encode([
                        'carrier_payment_type' => $paymentType['payment_type'],
                        'carrier_delivery_type' => $paymentType['delivery'],
                        'arrival_payment_message' => $this->module->l(
                            'The actual amount of the quote may change once the weight, dimensions and route entered 
                            in the form have been validated. You can confirm the value in the shipment tracking.',
                            'starkenendpoints'
                        ),
                    ]);
                } else {
                    echo json_encode([
                        'carrier_payment_type' => $paymentType['payment_type'],
                        'carrier_delivery_type' => $paymentType['delivery'],
                    ]);
                }
                
                exit;
            }

            if (Tools::isSubmit('rate')) {
                echo json_encode(['rated' => $this->module->hookActionCartSave()]);
                exit;
            }

            if (
                // Tools::isSubmit('agency_dls') &&
                Tools::isSubmit('state_id')
                && Tools::isSubmit('customer_id')
            ) {
                SwastarkenclCustomersAgency::deleteByCustomer(Tools::getValue('customer_id'));
                $swastarkenclCustomersAgency = new SwastarkenclCustomersAgency();
                $swastarkenclCustomersAgency->state_id = Tools::getValue('state_id');
                $swastarkenclCustomersAgency->customer_id = Tools::getValue('customer_id');
                $swastarkenclCustomersAgency->agency_dls = (int) Tools::getValue('agency_dls');
                $swastarkenclCustomersAgency->payment_on_arrival = Tools::getValue('payment_on_arrival');
                if ($swastarkenclCustomersAgency->save()) {
                    echo json_encode(
                        [
                            'message' => $this->module->l('Agency preferences was save', 'starkenendpoints'),
                            'result' => true
                        ]
                    );
                } else {
                    echo json_encode(['result' => false]);
                }
                exit;
            }

            if (Tools::isSubmit('ctacte')) {
                $curl = new Curl\Curl();
                $curl->setHeader('Content-Type', 'application/json');
                $curl->setHeader('Authorization', 'Bearer ' . Configuration::get('SWASTARKENCL_USER_TOKEN'));
                $curl->get(
                    Configuration::get('SWASTARKENCL_API_URL')
                    . '/emision/credito-cliente/cc/' . Tools::getValue('ctacte')
                );

                echo json_encode($curl->response);
                exit;
            }

            $starkenCommuneId = SwastarkenclState::getStakenIdById(Tools::getValue('state_id'));
            $curl = new Curl\Curl();
            $curl->setHeader('Content-Type', 'application/json');
            $curl->setHeader('Authorization', 'Bearer ' . Configuration::get('SWASTARKENCL_USER_TOKEN'));
            $curl->get(Configuration::get('SWASTARKENCL_API_URL') . '/agency/comuna/' . $starkenCommuneId);

            echo json_encode($curl->response);
            exit;
        }
    }
}
