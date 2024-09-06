<?php

use App\Http\Controllers\{
    ApplicantController,
    ProfileController,
    DashboardController,
    ReportController,
    MisController,
    MPropertyIdController,
    CommonController,
    MapController,
    OfficialDashboardController,
    ScriptController,
    RgrController,
    ColonyController,
    OfficialController,
    SteetviewController,
    PropertySectionMappingController,
    AppointmentDetailController,
    MessageTempleteController
};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\logistic\PurchaseController;
use App\Http\Controllers\logistic\SupplierVendorDetailsController;
use App\Http\Controllers\logistic\ItemsController;
use App\Http\Controllers\logistic\RequestProcessingController;
use App\Http\Controllers\logistic\IssueController;
use App\Http\Controllers\logistic\CategoryController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Settings\MailController;
use App\Http\Controllers\Settings\SmsController;
use App\Http\Controllers\Settings\WhatsappController;
use App\Http\Controllers\Settings\ActionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/propert-sub-type', [MisController::class, 'prpertySubTypes'])->name('prpertySubTypes');
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/colony-filter', [DashboardController::class, 'dashbordColonyFilter'])->name('dashbordColonyFilter');

    Route::get('/dashboard/property-type-data/{typeId}/{coonyId?}', [DashboardController::class, 'propertyTypeDetails'])->name('propertyTypeDetails');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('report/filter', [ReportController::class, 'getPropertyResults'])->name('getPropertyResults');
    Route::post('report/get-distinct-subType', [ReportController::class, 'getDistinctSubTypes'])->name('getDistinctSubTypes');
    Route::post('report/export', [ReportController::class, 'reportExport'])->name('reportExport');
    Route::get('/report/detailed-report', [ReportController::class, 'detailedReport'])->name('detailedReport');

    Route::get('/property-form', [MisController::class, 'index'])->name('mis.index');
    Route::post('/property-form/store', [MisController::class, 'store'])->name('mis.store');
    Route::get('/property-form-multiple', [MisController::class, 'misFormMultiple'])->name('mis.form.multiple');
    Route::post('/property-form-multiple/store', [MisController::class, 'misStoreMultiple'])->name('mis.store.multiple');
    Route::get('/property-details', [MisController::class, 'propertDetails'])->name('propertDetails')->middleware('permission:viewDetails');
    Route::delete('property-destroy/{id}', [MisController::class, 'propertyDestroy'])->name('property.destroy');
    Route::get('/property-details/child/{id}', [MisController::class, 'propertyChildDetails'])->name('propertyChildDetails')->middleware('permission:viewDetails');
    Route::post('/property/search', [MPropertyIdController::class, 'propertySearchById'])->name('propertySearch');
    Route::post('/is-property-available', [MPropertyIdController::class, 'isPropertyAvailable'])->name('isPropertyAvailable');
    Route::get('/tabular-record', [ReportController::class, 'tabularRecord'])->name('tabularRecord');
    Route::get('/property-details/{property}/view', [MisController::class, 'viewDetails'])->name('viewDetails')->middleware('permission:viewDetails');
    Route::get('/property-details/{property}/edit', [MisController::class, 'editDetails'])->name('editDetails')->middleware('permission:viewDetails');
    Route::get('/property-details/{property}/child-edit', [MisController::class, 'editChildDetails'])->name('editChildDetails')->middleware('permission:viewDetails');
    Route::put('/property-details/child/{property}', [MisController::class, 'updateChild'])->name('mis.update.child')->middleware('permission:viewDetails');
    Route::put('/property-details/{property}', [MisController::class, 'update'])->name('mis.update')->middleware('permission:viewDetails');
    Route::get('/property-details/{property}/view-property-details', [MisController::class, 'viewPropertyDetails'])->name('viewPropertyDetails'); //->middleware('permission:viewPropertyDetails');

    Route::get('/property-details/{property}/view-property-details', [MisController::class, 'viewPropertyDetails'])->name('viewPropertyDetails'); //->middleware('permission:viewPropertyDetails');
    Route::post('/property-original-destroy/{id}', [MisController::class, 'destroyOriginalById'])->name('original.destroy');
    Route::post('/property-land-batch-transfer-destroy/{batchId}/{propertyMasterId}', [MisController::class, 'destroyLandTransferByBatchId'])->name('property.land.batch.transfer.destroy');
    Route::post('/property-land-batch-transfer-individual-destroy/{landTransferId}/{batchId}/{propertyMasterId}', [MisController::class, 'destroyLandTransferByIndividualId'])->name('property.land.batch.transfer.individual.destroy');
    Route::get('/user-actions-logs', [MisController::class, 'actionLogListings'])->name('actionLogListings')->middleware('permission:viewDetails');
    Route::get('get/userActionsLogs', [MisController::class, 'getUserActionLogs'])->name('getUserActionLogs');
    Route::post('/get-old-property-status/{propertyId}/{propertyStatusId}', [MisController::class, 'getOldPropertyStatusValue'])->name('get.old.property.value');
    Route::post('/soft-delete-old-property-status-record', [MisController::class, 'softDeleteOldPropertyStatusRecord'])->name('soft.delete.old.property.status.record');

    //Add by lalit on 29/07/2024 to show register user listing
    Route::get('register/users', [OfficialController::class, 'index'])->name('regiserUserListings')->middleware('permission:view.register.user.listings');
    Route::get('get/registered/users', [OfficialController::class, 'getRegisteredUsers'])->name('get.registered.users');
    Route::put('registration/status/{id}', [OfficialController::class, 'updateStatus'])->name('update.registration.status');
    Route::get('register/user/{id}/view', [OfficialController::class, 'details'])->name('register.user.details');
    Route::post('register/user/{id}/', [OfficialController::class, 'checkProperty'])->name('register.user.checkProperty');
    Route::post('approve/user/registration', [OfficialController::class, 'approvedUserRegistration'])->name('approve.user.registration');
    Route::put('register/user/{id}', [OfficialController::class, 'rejectUserRegistration'])->name('reject.user.registration');
    Route::put('review/user/registration/{id}', [OfficialController::class, 'reviewUserRegistration'])->name('review.user.registration');
    Route::post('approve/review/application', [OfficialController::class, 'approvedReviewApplication'])->name('approve.review.application');

    // Applicant Routes added by Lalit on 12/08/2024
    Route::get('applicant/profile', [ApplicantController::class, 'index'])->name('applicant.profile');
    Route::get('applicant/property/details', [ApplicantController::class, 'propertiesDetails'])->name('applicant.properties')->middleware('role:applicant');
    Route::get('new/application', [ApplicantController::class, 'newApplication'])->name('new.application');
    Route::get('application/history', [ApplicantController::class, 'applicationHistory'])->name('application.history');

    Route::post('applicant/property/store', [ApplicantController::class, 'storeNewProperty'])->name('applicant.properties.store');
    // Applicant Routes added by Lalit on 21/08/2024
    Route::get('applicant/new/properties', [OfficialController::class, 'applicantNewProperties'])->name('applicantNewProperties');
    Route::get('get/applicant/property/listings', [OfficialController::class, 'getApplicantPropertyListings'])->name('get.applicant.property.listings');
    Route::get('applicant/property/{id}/view', [OfficialController::class, 'newPropertyDetails'])->name('applicant.properties.details');
    Route::put('review/applicant/new/property/{id}', [OfficialController::class, 'reviewApplicantNewProperty'])->name('review.applicant.new.property');
    Route::post('approve/review/applicant/new/property', [OfficialController::class, 'approvedReviewApplicantNewProperty'])->name('approve.review.applicant.new.property');
    Route::put('reject/applicant/new/property/{id}', [OfficialController::class, 'rejectApplicantNewProperty'])->name('reject.applicant.new.property');
    Route::post('approve/applicant/new/property', [OfficialController::class, 'approvedApplicantNewProperty'])->name('approve.applicant.new.property');

    Route::group(['middleware' => ['can:create.rgr']], function () {
        Route::get('rgr', [RgrController::class, 'index'])->name('rgr');
        Route::get('rgr-single-property', [RgrController::class, 'singlePropertyRGRInput'])->name('singlePropertyRGRInput');
        Route::get('rgr-colony', [RgrController::class, 'rgrColony'])->name('rgrColony');

        Route::post('rgr/create', [RgrController::class, 'create'])->name('createRgr');
        Route::post('rgr/calculate', [RgrController::class, 'calculateGroundRent'])->name('calculateGroundRent');

        Route::post('rgr/check-area-chnaged', [RgrController::class, 'checAreaChanged'])->name('checAreaChanged');
        Route::post('rgr/check-property-status-chnaged', [RgrController::class, 'checkPropertyStatusChanged'])->name('checkPropertyStatusChanged');
        Route::post('rgr/save-edited-rgr', [RgrController::class, 'saveEditedRGR'])->name('saveEditedRGR');
        Route::post('rgr/edit-multiple-rgr', [RgrController::class, 'editMultipleRGR'])->name('editMultipleRGR');
        Route::get('rgr/complete-list/{id?}', [RgrController::class, 'completeList'])->name('completeList');
    });
    Route::group(['middleware' => ['can:view.rgr.list']], function () {
        Route::get('rgr/list', [RgrController::class, 'list'])->name('rgrList');
        Route::get('rgr/property-rgr-details', [RgrController::class, 'rgrDetailsForProperty'])->name('rgrDetailsForProperty');
    });
    Route::group(['middleware' => ['can:create.rgr.draft']], function () {
        Route::get('rgr/save-as-pdf/{id}', [RgrController::class, 'saveAsPdf'])->name('saveAsPdf');
        Route::post('rgr/save-multiple-pdf', [RgrController::class, 'saveMultiplePdf'])->name('saveMultiplePdf');
    });
    Route::group(['middleware' => ['can:send.rgr.draft']], function () {
        Route::get('rgr/send-draft/{rgrId}', [RgrController::class, 'sendDraft'])->name('sendDraft');
        Route::post('rgr/send-multiple-draft', [RgrController::class, 'sendMultipleDrafts'])->name('sendMultipleDrafts');
    });
    Route::post('rgr/colony-rgr', [RgrController::class, 'reviseGroundRentForColony'])->name('reviseGroundRentForColony');
    Route::get('rgr/view-draft/{rgrId}', [RgrController::class, 'viewDraft'])->name('viewDraft');
    Route::get('rgr/status-change-list', [RgrController::class, 'statusChangeList'])->name('statusChangeList');
    Route::get('rgr/area-change-list', [RgrController::class, 'areaChangeList'])->name('areaChangeList');
    Route::get('rgr/reentered-list', [RgrController::class, 'reenteredList'])->name('reenteredList');
    Route::get('rgr/properties-in-block/{colonyId}/{blockId}/{leaseHoldOnly?}', [RgrController::class, 'propertiesInBlock'])->name('propertiesInBlock');
    Route::get('rgr/blocks-in-colony/{colonyId}/{leaseHoldOnly?}', [RgrController::class, 'blocksInColony'])->name('blocksInColony');
    Route::post('rgr/property-basic-detail', [RgrController::class, 'propertyBasicdetail'])->name('propertyBasicdetail');
    Route::post('rgr/colony-details', [RgrController::class, 'colonyRGRDetails'])->name('colonyRGRDetails');


    Route::group(['middleware' => ['isAdmin']], function () {
        //Permissions
        Route::resource('permissions', App\Http\Controllers\PermissionController::class);
        Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);

        //Roles
        Route::resource('roles', App\Http\Controllers\RoleController::class);
        Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
        Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
        Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);

        //Users
        Route::resource('users', App\Http\Controllers\UserController::class);
        Route::get('getUserList',[App\Http\Controllers\UserController::class, 'getUserList'])->name('getUserList');
        Route::get('users/{userId}/delete', [App\Http\Controllers\UserController::class, 'destroy'])->middleware('permission:delete user');
        Route::post('property-details/export', [ReportController::class, 'detailsExport'])->name('detailsExport');
        Route::get('users/{id}/status', [App\Http\Controllers\UserController::class, 'status'])->name('user.status')->middleware('permission:status.user');
        Route::post('report/filter', [ReportController::class, 'getPropertyResults'])->name('getPropertyResults');
        Route::post('report/get-distinct-subType', [ReportController::class, 'getDistinctSubTypes'])->name('getDistinctSubTypes');
        Route::post('report/export', [ReportController::class, 'reportExport'])->name('reportExport');

        //Import Functionality 
        Route::post('/import-lndo-land-rates', [ImportController::class, 'importLndoLandRate'])->name('lndoLandRates.import');
        Route::get('/import-lndo-land-rates', function () {
            return view('import-excel.import-lndo-land-rate');
        })->name('lndo.import');

        Route::post('/import-circle-rates', [ImportController::class, 'importCircleRate'])->name('circleRates.import');
        Route::get('/import-circle-rates', function () {
            return view('import-excel.import-circle-rate');
        })->name('circle.import');

        //Common Activities
        Route::get('change-date', [App\Http\Controllers\CommonController::class, 'changeLeaseExpirationDate'])->name('changeLeaseExpirationDate'); //To update the expiration date -- 22-05-2024


        //property assignment routes
        Route::get('/property-assignment', [PropertySectionMappingController::class, 'propertyAssignment'])->name('propertyAssignment');
        Route::post('/get-all-property-types', [PropertySectionMappingController::class, 'getAllPropertyTypes'])->name('getAllPropertyTypes');
        Route::post('/property-assignment', [PropertySectionMappingController::class, 'propertyAssignmentStore'])->name('propertyAssignmentStore');
        Route::post('/i-colony-assigned-to-section', [PropertySectionMappingController::class, 'isColonyAssignedToSection'])->name('isColonyAssignedToSection');



        //settings*************************************************************
        //Mail
        Route::get('/setting/mail', [MailController::class, 'index'])->name('settings.mail.index');
        Route::get('/setting/mail/create', [MailController::class, 'create'])->name('settings.mail.create');
        Route::post('/setting/mail/store', [MailController::class, 'store'])->name('settings.mail.store');
        Route::get('/setting/mail/status/{id}', [MailController::class, 'updateStatus'])->name('settings.mail.status')->middleware('permission:settings.mail.status');
        Route::get('/setting/mail/{id}', [MailController::class, 'edit'])->name('settings.mail.edit')->middleware('permission:settings.mail.update');
        Route::put('/setting/mail/{id}', [MailController::class, 'update'])->name('settings.mail.update')->middleware('permission:settings.mail.update');
        Route::get('/setting/mail/{id}/test', [MailController::class, 'mailTest'])->name('settings.mail.mailTest');


        //Sms
        Route::get('/setting/sms', [SmsController::class, 'index'])->name('settings.sms.index');
        Route::get('getSmsSettings', [SmsController::class, 'getSmsSettings'])->name('get.sms.settings');
        Route::get('/setting/sms/create', [SmsController::class, 'create'])->name('settings.sms.create');
        Route::post('/setting/sms/store', [SmsController::class, 'store'])->name('settings.sms.store');
        Route::get('/setting/sms/status/{id}', [SmsController::class, 'updateStatus'])->name('settings.sms.status')->middleware('permission:settings.sms.status');
        Route::get('/setting/sms/{id}', [SmsController::class, 'edit'])->name('settings.sms.edit')->middleware('permission:settings.sms.update');
        Route::put('/setting/sms/{id}', [SmsController::class, 'update'])->name('settings.sms.update')->middleware('permission:settings.sms.update');
        Route::get('/setting/sms/{id}/test', [SmsController::class, 'smsTest'])->name('settings.sms.smsTest');


        //Whatsapp
        Route::get('/setting/whatsapp', [WhatsappController::class, 'index'])->name('settings.whatsapp.index');
        Route::get('getWhatsappSettings', [WhatsappController::class, 'getWhatsappSettings'])->name('get.whatsapp.settings');
        Route::get('/setting/whatsapp/create', [WhatsappController::class, 'create'])->name('settings.whatsapp.create');
        Route::post('/setting/whatsapp/store', [WhatsappController::class, 'store'])->name('settings.whatsapp.store');
        Route::get('/setting/whatsapp/status/{id}', [WhatsappController::class, 'updateStatus'])->name('settings.whatsapp.status')->middleware('permission:settings.whatsapp.status');
        Route::get('/setting/whatsapp/{id}', [WhatsappController::class, 'edit'])->name('settings.whatsapp.edit')->middleware('permission:settings.whatsapp.update');
        Route::put('/setting/whatsapp/{id}', [WhatsappController::class, 'update'])->name('settings.whatsapp.update')->middleware('permission:settings.whatsapp.update');
        Route::get('/setting/whatsapp/{id}/test', [WhatsappController::class, 'whatsappTest'])->name('settings.whatsapp.whatsappTest');


        //actions
        Route::get('/setting/action', [ActionController::class, 'index'])->name('settings.action.index');
        Route::get('/setting/action/create', [ActionController::class, 'create'])->name('settings.action.create');
        Route::post('/setting/action/store', [ActionController::class, 'store'])->name('settings.action.store');
        Route::get('/setting/action/{id}', [ActionController::class, 'index'])->name('settings.action.edit')->middleware('permission:settings.action.update');
        Route::put('/setting/action/{id}', [ActionController::class, 'update'])->name('settings.action.update')->middleware('permission:settings.action.update');
    });



    Route::group(['middleware' => ['isAdmin']], function () {
        Route::get('/logistic/items', [ItemsController::class, 'index'])->name('logistic.index');
        Route::get('/logistic/items/add', [ItemsController::class, 'create'])->name('logistic.create');
        Route::post('/logistic_items', [ItemsController::class, 'store'])->name('logistic_items.store');
        Route::post('/logistic/items/update', [ItemsController::class, 'update'])->name('logistic_items.update');
        Route::post('/logistic/items/updatelabel', [ItemsController::class, 'updatelabel']);
        // Route::get('/logistic/items/{roleId}/delete', [ItemsController::class, 'destroy'])->name('logistic.delete');
        Route::get('logistic/items/{itemId}/update-status', [ItemsController::class, 'updateStatus'])->name('items.updateStatus');
        Route::get('/logistic/items/{id}/edit', [ItemsController::class, 'edit'])->name('logistic.edit');
        Route::put('/logistic/items/{id}', [ItemsController::class, 'update'])->name('logistic.update');
        Route::get('/logistic/items/autocomplete', [ItemsController::class, 'autocomplete'])->name('items.autocomplete');

        Route::get('/logistic/category', [CategoryController::class, 'index'])->name('category.index');
        Route::post('/logistic/category/update', [CategoryController::class, 'update']);
        Route::get('/logistic/category/add', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/logistic_category', [CategoryController::class, 'store'])->name('logistic_category.store');
        Route::get('logistic/category/{itemId}/update-status', [CategoryController::class, 'updateStatus'])->name('category.updateStatus');
        // Route::get('/logistic/category/{roleId}/delete', [CategoryController::class, 'destroy'])->name('logisticCategory.delete');
        Route::get('/logistic/category/autocomplete', [CategoryController::class, 'autocomplete'])->name('category.autocomplete');
        Route::post('/logistic/category/check-name', [CategoryController::class, 'checkName'])->name('logistic_category.checkName');


        Route::get('/logistic/purchase', [PurchaseController::class, 'index'])->name('purchase.index');
        Route::get('getPurchaseItems', [PurchaseController::class, 'getPurchaseItems'])->name('get.purchase.items');
        Route::get('/logistic/purchase/add', [PurchaseController::class, 'create'])->name('purchase.create');
        Route::post('/logistic_purchase', [PurchaseController::class, 'store'])->name('logistic_purchase.store');
        Route::get('/logistic/purchase/{roleId}/delete', [PurchaseController::class, 'destroy']);
        Route::get('/logistic/purchase/{id}/edit', [PurchaseController::class, 'edit'])->name('purchase.edit');
        Route::put('/logistic/purchase/{id}', [PurchaseController::class, 'update'])->name('purchase.update');
        Route::get('/logistic/available-units/{logisticItemId}', [PurchaseController::class, 'getAvailableUnits']);


        Route::get('/logistic/history', [PurchaseController::class, 'indexHistory'])->name('purchaseHistory.index');
        Route::get('getLogisticHistories', [PurchaseController::class, 'getLogisticHistories'])->name('get.logistic.histories');
        Route::get('/logistic/stock', [PurchaseController::class, 'stockIndex'])->name('purchaseStock.index');


        Route::get('/logistic/issued-item', [IssueController::class, 'create'])->name('issued_item.create');
        Route::post('/logistic/issued-item', [IssueController::class, 'store'])->name('issued_item.store');
        Route::get('/get-available-units/{id}', [PurchaseController::class, 'getAvailableUnits']);
        // Route::post('/logistic/issued-item/{issuedItem}', [IssueController::class, 'update'])->name('issued_item.update');
        // Route::get('/logistic/issued-items', [IssueController::class, 'index'])->name('issued_item.index');
        // Route::post('/logistic/issued-items/update', [IssueController::class, 'updateEditable']);

        Route::get('/logistic/requested-items', [RequestProcessingController::class, 'index'])->name('requested_item.index');
        Route::get('getLogisticRequestItems', [RequestProcessingController::class, 'getLogisticRequestItems'])->name('get.logistic.request.items');
        Route::get('/logistics/request/{requestId}/create', [RequestProcessingController::class, 'create'])->name('request.create');
        Route::post('/logistics/request/{requestId}/update', [RequestProcessingController::class, 'updateStatus'])->name('request.update');


        Route::get('/logistic/vendor', [SupplierVendorDetailsController::class, 'index'])->name('supplier.index');
        Route::get('/logistic/vendor/add', [SupplierVendorDetailsController::class, 'create'])->name('supplier.create');
        Route::post('/supplier_vendor_details', [SupplierVendorDetailsController::class, 'store'])->name('supplier_vendor_details.store');
        // Route::get('/logistic/vendor/{roleId}/delete', [SupplierVendorDetailsController::class, 'destroy']);
        Route::get('logistic/vendor/{itemId}/update-status', [SupplierVendorDetailsController::class, 'updateStatus'])->name('supplier.updateStatus');
        Route::get('/logistic/vendor/{id}/edit', [SupplierVendorDetailsController::class, 'edit'])->name('supplier.edit');
        Route::put('/logistic/vendor/{id}', [SupplierVendorDetailsController::class, 'update'])->name('supplier.update');

        //Communication Templates
        Route::get('/message-templates', [MessageTempleteController::class, 'show'])->name('msgtempletes');
        Route::get('getMessageTemplateListing', [MessageTempleteController::class, 'getMessageTemplateListing'])->name('getMessageTemplateListing');
        Route::get('/template/use/{id}', [MessageTempleteController::class, 'useTemplate'])->name('template.use');
        Route::put('/templates/{id}', [MessageTempleteController::class, 'update'])->name('templates.update');
        Route::get('/template/status/{id}', [MessageTempleteController::class, 'updateStatus'])->name('template.status');
        Route::get('/templates/create', [MessageTempleteController::class, 'create'])->name('templates.create');
        Route::post('/templates', [MessageTempleteController::class, 'store'])->name('templates.store');

        //appointment
        Route::get('/appointments', [AppointmentDetailController::class, 'index'])->name('appointments.index');
        Route::patch('/appointments/update-status/{id}', [AppointmentDetailController::class, 'updateStatus'])->name('appointments.updateStatus');
    });
});


Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/download/{file}', [ReportController::class, 'download']);

require __DIR__ . '/auth.php';

Route::get('/update-land-value/{id}', [ScriptController::class, 'updateLandValue'])->name('updateLandValue');
Route::get('/update-land-value-in-child/{id}', [ScriptController::class, 'updateLandValueInChild'])->name('updateLandValueInChild');
Route::get('/update-current-lessee/{id}', [ScriptController::class, 'updateCurrentLessee'])->name('updateCurrentLessee');
Route::get('/map', [MapController::class, 'map'])->name('map');
Route::get('/streetview/{id}', [SteetviewController::class, 'map'])->name('streetview');



Route::middleware('guest')->group(function () {
    Route::get('/public-register', [RegisteredUserController::class, 'publicRegister'])->name('publicRegister');
    Route::post('/public-register', [RegisteredUserController::class, 'publicRegisterCreate'])->name('publicRegisterCreate');
    Route::post('/save-otp', [RegisteredUserController::class, 'saveOtp'])->name('saveOtp');
    Route::post('/send-login-otp', [AuthenticatedSessionController::class, 'sendLoginOtp'])->name('sendLoginOtp');
    Route::post('/verifyLoginOtp', [AuthenticatedSessionController::class, 'verifyLoginOtp'])->name('verifyLoginOtp');
    Route::post('/verify-otp', [RegisteredUserController::class, 'verifyOtp'])->name('verifyOtp');
    Route::post('/locality-blocks', [ColonyController::class, 'localityBlocks'])->name('localityBlocks');
    Route::post('/block-plots', [ColonyController::class, 'blockPlots'])->name('blockPlots');
    Route::post('/plot-knownas', [ColonyController::class, 'plotKnownas'])->name('plotKnownas');


    Route::get('/appointment-detail', [AppointmentDetailController::class, 'create'])->name('appointmentDetail');
    Route::post('/appointment-detail', [AppointmentDetailController::class, 'store'])->name('appointmentStore');
    Route::get('/appointments/get-available-time-slots', [AppointmentDetailController::class, 'getAvailableTimeSlots']);
    Route::get('/appointments/get-fully-booked-dates', [AppointmentDetailController::class, 'getFullyBookedDates']);
    // Route::get('/appointments', [AppointmentDetailController::class, 'index'])->name('appointments.index');
    // Route::patch('/appointments/update-status/{id}', [AppointmentDetailController::class, 'updateStatus'])->name('appointments.updateStatus');
});

Route::post('/locality-blocks', [ColonyController::class, 'localityBlocks'])->name('localityBlocks');
Route::post('/block-plots', [ColonyController::class, 'blockPlots'])->name('blockPlots');
Route::post('/plot-knownas', [ColonyController::class, 'plotKnownas'])->name('plotKnownas');
