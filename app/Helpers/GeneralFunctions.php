<?php

namespace App\Helpers;

use App\Models\UserActionLog;
use Illuminate\Support\Facades\Auth;
use App\Models\Module;
use App\Models\Otp;
use App\Models\UserRegistration;
use App\Models\PropertyMaster;
use App\Models\UserProperty;
use App\Models\ApplicantUserDetail;
use App\Models\Item;
use URL;
use Illuminate\Support\Facades\Storage;

class GeneralFunctions
{
    //for generating otp
    public static function generateUniqueRandomNumber($digits)
    {
        $maxAttempts = 10;
        while ($maxAttempts > 0) {
            $randomNumber = mt_rand(pow(10, $digits - 1), pow(10, $digits) - 1); // Generate random number
            $exists = Otp::where('email_otp', $randomNumber)->where('mobile_otp', $randomNumber)->exists();
            if (!$exists) {
                return $randomNumber;
            }

            $maxAttempts--;
        }

        throw new Exception("Unable to generate a unique random number within the specified attempts.");
    }

    //for uploding file
    public static function uploadFile($file, $pathToUpload, $type)
    {
        $date = now()->format('YmdHis');
        $fileName = $type . '_' . $date . '.' . $file->extension();
        $path = $file->storeAs($pathToUpload, $fileName, 'public');
        return $path;
    }



    //For generating registration number
    public static function generateRegistrationNumber()
    {
        $lastRegistration = UserRegistration::latest('created_at')->first();

        if ($lastRegistration) {
            $lastNumber = intval(substr($lastRegistration->applicant_number, 4)); // Skip 'REG-'
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        $formattedNumber = str_pad($newNumber, 7, '0', STR_PAD_LEFT);
        $registrationNumber = 'APL' . $formattedNumber;
        return $registrationNumber;
    }

    public static function isPropertyFree($propertyId)
    {
        $property = PropertyMaster::where('old_propert_id', $propertyId)->first();
        if ($property) {
            $ispropertyLinked = UserProperty::where('old_property_id', $propertyId)->first();
            if ($ispropertyLinked) {
                $applicant = ApplicantUserDetail::where('user_id', $ispropertyLinked['user_id'])->first();
                $applicantNumber = $applicant['applicant_number'];
                // $user = User::where('id',$ispropertyLinked['user_id'])->first();
                $data = [
                    'success' => false,
                    'message' => 'Property linked with another applicant ' . $applicantNumber . ' .',
                    'details' => '<h6 class="text-danger">Property linked with another applicant ' . $applicantNumber . '</h6>
                            <table class="table table-bordered property-table-info">
                                <tbody>
                                    <tr>
                                        <th>Name :</th>
                                        <td>'.$applicant->user->name.'</td>
                                        <th>Email :</th>
                                        <td>'.$applicant->user->email.'</td>
                                    </tr>
                                    <tr>
                                    <th>Mobile:</th>
                                        <td>'.$applicant->user->mobile_no.'</td>
                                        <th>Address:</th>
                                        <td>'.$applicant->address.'</td>
                                        
                                    </tr>
                                    <tr>
                                        <th>PAN:</th>
                                        <td>'.$applicant->pan_card.'</td>
                                        <th>Aadhar:</th>
                                        <td>'.$applicant->aadhar_card.'</td>
                                    </tr>
                                </tbody>
                            </table>'
                ];
            } else {
                $data = [
                    'success' => true,
                    'message' => 'Property is free',
                    'details' => ''
                ];
            }
            return $data;
        }
    }

    public static function getItemsByGroupId($id){
        return Item::where('group_id',$id)->get();
    }
}
