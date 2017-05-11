<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Models\GlobalSetting;
use App\Models\MakeAnOfferSetting;
use App\Models\RewardPointSetting;
use App\Models\Vendor;
use App\Models\ShippingCarrierSetting;
use App\Models\ProductSetting;
use Datatables;


class GlobalSettingController extends Controller {

    public $objMakeAnOffer;
    public $objRewardPoint;
    public $objShippingCarrier;
    public $objVendor;

    public function __construct() {
        $this->objMakeAnOffer       = new MakeAnOfferSetting();
        $this->objRewardPoint       = new RewardPointSetting();
        $this->objShippingCarrier   = new ShippingCarrierSetting();
        $this->objVendor            = new Vendor();
        $this->objProductSenting    = new ProductSetting();
    }

    public function showGlobalSettingForm() {
        $makeAnOfferSetting = $this->objMakeAnOffer->getActiveMakeAnOfferSetting();
        $rewardPointSetting = $this->objRewardPoint->getActiveRewardPointSetting();
        $productSetting     = $this->objProductSenting->getActiveProductSetting();
        //dd($productSetting);
        $shippingCarrierSetting = $this->objVendor->getActiveVendorWithShippingCarrierSetting();
        //echo "<pre>";print_r($shippingCarrierSetting);die;

        return view('admin.global_setting.form', compact('makeAnOfferSetting', 'rewardPointSetting', 'shippingCarrierSetting','productSetting'));
    }

    public function postMakeAnOfferSetting(Request $request) {
        $validation = [
            'time_to_retract_offer' => 'required|numeric',
        ];

        $this->validate($request, $validation);

        // Start transaction!
        DB::beginTransaction();
        try {
            // previous active record
            $makeAnOfferSetting = $this->objMakeAnOffer->getActiveMakeAnOfferSetting();

            if (!empty($makeAnOfferSetting)) {
                $this->objMakeAnOffer->updateInactiveMakeAnOfferSetting($makeAnOfferSetting['id']);
            }

            $this->objMakeAnOffer->createMakeAnOfferSetting($request);
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            // back to form with errors
            return response()->json(['status' => 'error', 'messages' => ['global_form_message' => trans('message.failure')]]);
        }
        // If we reach here, then data is valid and working. Commit the queries!postRewardPointSetting
        DB::commit();

        return response()->json(['status' => 'success', 'message' => trans('message.global_setting.make_offer_setting_success')]);
    }

    public function postRewardPointSetting(Request $request) {
        $validation = [
            'buyer_earns_reward_point_on_purchase_of_every' => 'required|numeric',
            'reward_point_value' => 'required|numeric',
            'effective_from_date' => 'required|date',
        ];

        $this->validate($request, $validation);

        // Start transaction!
        DB::beginTransaction();
        try {
            // previous active record
            $rewardSetting = $this->objRewardPoint->getActiveRewardPointSetting();

            if (!empty($rewardSetting)) {
                $this->objRewardPoint->updateInactiveRewardPointSetting($rewardSetting['id']);
            }

            $this->objRewardPoint->createRewardPointSetting($request);
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            // back to form with errors
            return response()->json(['status' => 'error', 'messages' => ['global_form_message' => trans('message.failure')]]);
        }
        // If we reach here, then data is valid and working. Commit the queries!
        DB::commit();

        return response()->json(['status' => 'success', 'message' => trans('message.global_setting.reward_point_setting_success')]);
    }

    public function postShippingCarrierSetting(Request $request, $vendor_id) {
        $vendor_id = decrypt($vendor_id);

        $validation = [
            'additional_profit_margin' => 'required|numeric',
            'active_in_system' => 'required',
            'effective_from_date' => 'required|date'
        ];

        $this->validate($request, $validation);

        $request->merge(['vendor_id' => $vendor_id]);

        // Start transaction!
        DB::beginTransaction();
        try {
            // previous active record
            $shippingCarrierSetting = $this->objShippingCarrier->getActiveShippingCarrierSetting($vendor_id);

            if (!empty($shippingCarrierSetting)) {
                $this->objShippingCarrier->updateInactiveShippingCarrierSetting($shippingCarrierSetting['id']);
            }

            $this->objShippingCarrier->createShippingCarrierSetting($request);
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            // back to form with errors
            return response()->json(['status' => 'error', 'messages' => ['global_form_message' => trans('message.failure')]]);
        }
        // If we reach here, then data is valid and working. Commit the queries!
        DB::commit();

        return response()->json(['status' => 'success', 'message' => trans('message.global_setting.shipping_carrier_setting_success')]);
    }

    public function getShippingCarrierSettingLogPopup($vendorId) {
        return view('admin.global_setting.shipping_carriers_logs', compact('vendorId'));
    }

    public function getShippingCarrierSettingLog($vendorId) {
        $vendorId = decrypt($vendorId);
        $settings = ShippingCarrierSetting::select('id', 'active_in_system', 'additional_profit_margin', 'effective_from_date', 'created_at', 'updated_at', 'status')
                ->where('vendor_id', $vendorId);
        return Datatables::of($settings)
                /*->editColumn('active_in_system', '<span class="label label-success"> {{$active_in_system}} </span>')*/
                ->editColumn('effective_from_date', function ($setting) {
                    return $setting->effective_from_date ? with(new Carbon($setting->effective_from_date))->format('Y-m-d') : '';
                })
                ->make(true);
    }
    
    public function getRewardPointSettingLogPopup() {
        return view('admin.global_setting.reward_points_logs');
    }
    
    public function getRewardPointSettingLog() {
        $settings = RewardPointSetting::select('id', 'buyer_earns_reward_point_on_purchase_of_every', 'reward_point_value', 'effective_from_date', 'created_at', 'updated_at', 'status');
        return Datatables::of($settings)
                ->editColumn('effective_from_date', function ($setting) {
                    return $setting->effective_from_date ? with(new Carbon($setting->effective_from_date))->format('Y-m-d') : '';
                })
                ->make(true);
    }

    public function postProductSetting(Request $request) {
        $validation = [
            'allow_no_of_images'    => 'required|numeric',
            'expiration_day'        => 'required|numeric',
        ];

        $this->validate($request, $validation);
        // Start transaction!
        DB::beginTransaction();
        try {
            // previous active record
            $productSetting = $this->objProductSenting->getActiveProductSetting();

            if (!empty($productSetting)) {
                $this->objProductSenting->updateProductSetting($productSetting['id']);
            }
            $this->objProductSenting->createProductSetting($request);
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            // back to form with errors
            return response()->json(['status' => 'error', 'messages' => ['global_form_message' => trans('message.failure')]]);
        }
        // If we reach here, then data is valid and working. Commit the queries
        DB::commit();

        return response()->json(['status' => 'success', 'message' => trans('message.global_setting.product_setting_success')]);
    }

}
