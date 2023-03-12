<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaxController;

use App\Http\Controllers\FloorController;

use App\Http\Controllers\UserController;

use App\Http\Controllers\LabelController;
use App\Http\Controllers\MealsController;

use App\Http\Controllers\LedgerController;

use App\Http\Controllers\MarketController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RateCodeController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\RoomStatusController;


use App\Http\Controllers\ActivitylogController;

use App\Http\Controllers\CalculationController;

use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\MealPackageController;



use App\Http\Controllers\OordServiceController;

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\companyProfileController;
use App\Http\Controllers\SourceBusinessController;

use App\Http\Controllers\MaintenanceTypeController;
use App\Http\Controllers\CompanyStatementController;
use App\Http\Controllers\Api\V1\Rooms\RoomController;
use App\Http\Controllers\RateChangeHistoryController;
use App\Http\Controllers\Api\V1\Permission\RoleController;
use App\Http\Controllers\Api\V1\Rooms\RoomChangeController;
use App\Http\Controllers\Api\V1\Subscription\PlanController;

use App\Http\Controllers\Api\V1\Subscription\FeatureController;
use App\Http\Controllers\Api\V1\Permission\PermissionController;
use App\Http\Controllers\Api\V1\Profiles\GuestProfile\WindowController;
use App\Http\Controllers\Api\v1\Profiles\GuestProfile\ReservationController;
use App\Http\Controllers\Api\V1\Profiles\GuestProfile\GuestInhouseController;
use App\Http\Controllers\Api\V1\Profiles\GuestProfile\GuestProfileController;

use App\Http\Controllers\ExtendStayController;


Route::post('user-login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('user-logout', [AuthController::class, 'logout']);
    Route::resource('user', UserController::class);
    Route::get('userPagination/{id}', [UserController::class,'userPagination']);

    Route::resource('categories', CategoryController::class);
    Route::get('categoryPagination/{id}', [CategoryController::class, 'categoryPagination']);
    Route::resource('labels', LabelController::class);
    Route::get('labelPagination/{id}', [LabelController::class, 'labelPagination']);
    Route::resource('tickets', TicketController::class);
    Route::get('ticketsPagination/{id}', [TicketController::class, 'ticketPagination']);
    Route::post('tickets/upload', [TicketController::class, 'upload']);
    Route::post('tickets/{ticket}/close', [TicketController::class, 'close']);
    Route::post('tickets/{ticket}/reopen', [TicketController::class, 'reopen']);
    Route::post('tickets/{ticket}/archive', [TicketController::class, 'archive']);


    Route::resource('room_types', RoomTypeController::class);
    Route::get('room_types_pagination/{id}', [RoomTypeController::class, 'roomTypePagiantion']);

    Route::resource('tax', TaxController::class);
    Route::get('taxPagination/{id}', [TaxController::class, 'taxPagination']);
    Route::resource('ledger', LedgerController::class);
    Route::get('ledger-cats',[LedgerController::class,'ledger_cats']);
    Route::resource('activities', ActivitylogController::class);
    Route::get('activityPagination/{id}', [ActivitylogController::class, 'activityPagination']);

    Route::resource('meals', MealsController::class);
    Route::get('mealsPagination/{id}', [MealsController::class, 'mealsPagination']);
    Route::resource('meal-packages', MealPackageController::class);
    Route::get('meal-packages_pagination/{id}', [MealPackageController::class, 'mealPackagePagination']);



    Route::resource('transactions',TransactionController::class);
    Route::get('transactionsPagination/{id}',[TransactionController::class, 'transactionPagination']);
    
    Route::resource('lost-and-found',LostAndFoundController::class);
    Route::get('lost-and-found_pagination/{id}',[LostAndFoundController::class, 'lostAndFoundPagination']);

    Route::resource('reservation-status',ReservationStatusController::class);
    Route::get('reservation-status_pagiantion/{id}',[ReservationStatusController::class, 'rservationStatusPagination']);

    Route::apiResource('rooms', RoomController::class);
    Route::get('roomPagination/{id}', [RoomController::class,'roomPagination']);

    Route::get('getRoomsDeleted', [RoomController::class, 'geSoftDeletedData']);
    Route::post('restorRoomDataTrashed/{id}', [RoomController::class, 'restorDataTrashed']);

    Route::resource('rate-code',RateCodeController::class);
    Route::get('rate-code_pagination/{id}',[RateCodeController::class, 'ratePagination']);

    Route::resource('maintenance-type',MaintenanceTypeController::class);
    Route::get('maintenanceTypePagination/{id}',[MaintenanceTypeController::class, 'maintenanceTypePagination']);
    Route::resource('maintenance',MaintenanceController::class);
    Route::get('mainTenancePagination/{id}',[MaintenanceController::class, 'mainTenancePagination']);

    Route::get('room-maintenance/{id}',[MaintenanceController::class,'get_room_maintenances']);
    Route::get('maintenances-date',[MaintenanceController::class,'maintenances_date_with_filter']);

    Route::resource('room-status',RoomStatusController::class);
    Route::get('room-status_pagination/{id}',[RoomStatusController::class, 'roomStatus']);

    Route::apiResource('guestInhouse',GuestInhouseController::class);
    Route::get('inhousPagination/{id}',[GuestInhouseController::class,'inhousPagination']);


    Route::post('transaction_collection', [TransactionController::class, 'transaction_collection']);
    Route::get('calculate_excluded', [TransactionController::class, 'calculate_excluded']);
    

    Route::apiResource('reservation',ReservationController::class);
    Route::get('reservationPagination/{id}',[ReservationController::class,'reservationPagination']);
    Route::put('checkIn/{id}',[ReservationController::class,'checkIn']);
    Route::post('cancel/{id}',[ReservationController::class,'cancel']);
    Route::post('reInstate/{id}',[ReservationController::class,'reInstate']);
    Route::post('availability',[ReservationController::class,'availability']);


    Route::apiResource('window',WindowController::class);


    Route::apiResource('roomChange',RoomChangeController::class);
    Route::get('roomChangPagination/{id}',[RoomChangeController::class,'roomChangPagination']);



});

Route::resource('settings', SettingsController::class);

Route::get('taxes-calculation', [CalculationController::class, 'taxes']);

//Route::get('users',[AuthController::class,'users']);

Route::resource('language', LocalizationController::class);
Route::get('localizationPagination/{id}', [LocalizationController::class, 'localizationPagination']);

//Route::get('getAllPermissios/{id}', [PermissionController::class, 'index']);
//Route::post('getPermissionById/{id}', [PermissionController::class, 'getPermissionByID']);
//Route::post('updatePermission/{id}', [PermissionController::class, 'update']);
//Route::post('storePermission', [PermissionController::class, 'store']);
//Route::post('permissionDelete/{id}', [PermissionController::class, 'delete']);
//Route::post('updateUserPermissions/{id}', [PermissionController::class, 'updateUserPermissions']);

Route::get('getAllRoles', [RoleController::class, 'index']);
Route::get('getAllRolePaginate/{id}', [RoleController::class, 'getAllRolePaginate']);
Route::post('getRoleById/{id}', [RoleController::class, 'getRoleByID']);
Route::post('storeRole', [RoleController::class, 'store']);
Route::post('updateRole/{id}', [RoleController::class, 'updateRole']);
Route::post('assignPermissionRole/{id}', [RoleController::class, 'assignPermissionForRole']);
Route::post('deleteRole/{id}', [RoleController::class, 'destroy']);

Route::get('getAllPermissios', [PermissionController::class, 'index']);
Route::get('getAllPermissionPaginate{id}', [PermissionController::class, 'getAllPermissionPaginate']);
Route::post('getPermissionById/{id}', [PermissionController::class, 'getPermissionForUser']);
Route::post('updatePermission', [PermissionController::class, 'update']);
Route::post('storePermission', [PermissionController::class, 'store']);
Route::post('permissionDelete/{id}', [PermissionController::class, 'delete']);

// Route::get('getAllRoles', [RoleController::class, 'index']);
//Route::post('ruleById', [RoleController::class, 'getRoleForUser']);
//Route::post('getRoleById', [RoleController::class, 'getPermissionForUser']);
////Route::post('storeRole', [RoleController::class, 'store']);
//Route::post('updateRole', [RoleController::class, 'updateRole']);
//Route::post('deleteRole/{id}', [RoleController::class, 'destroy']);

Route::apiResource('plan', PlanController::class);
Route::get('planPagination/{id}', [PlanController::class,'planPagination']);
Route::post('assosiative/{id}', [PlanController::class, 'createPlanFeature']);
Route::get('getSoftDeletedData', [PlanController::class, 'geSoftDeletedData']);
Route::post('restorDataTrashed/{id}', [PlanController::class, 'restorDataTrashed']);
Route::post('planForceDelete/{id}', [PlanController::class, 'DBDelete']);

Route::apiResource('feature', FeatureController::class);
Route::get('featurePagination/{id}', [FeatureController::class,'featurePagination']);
Route::get('getSoftDeletedFeatureData', [FeatureController::class, 'geSoftDeletedData']);
Route::post('restorFeatureDataTrashed/{id}', [FeatureController::class, 'restorDataTrashed']);
Route::post('featureForceDelete/{id}', [FeatureController::class, 'DBDelete']);
Route::resource('floor',FloorController::class); 
Route::get('floorPaginate/{id}',[FloorController::class,'floorPaginate']); 
Route::post('restoreFloorDataTrashed/{id}',[FloorController::class,'restoreTrashed']);


Route::apiResource('guestProfile', GuestProfileController::class);
Route::get('profilePagination/{id}', [GuestProfileController::class,'profilePagination']);


Route::resource('segment', MarketController::class);
Route::get('segmentPaginate/{id}', [MarketController::class, 'marketPagination']);
Route::resource('sourcebusiness', SourceBusinessController::class);
Route::get('sourcebusinessPagination/{id}', [SourceBusinessController::class, 'sourceBusinessPagination']);
Route::apiResource('companyProfile', companyProfileController::class);
Route::get('companyProfilePagination/{id}', [companyProfileController::class, 'companyPagination']);
Route::resource('payment',PaymentController::class);
Route::get('paymentPagination/{id}',[PaymentController::class, 'paymentPagination']);

Route::resource('tenant', TenantController::class);
Route::get('tenantPagination/{id}', [TenantController::class, 'tenantPagination']);
Route::apiResource('guestProfile',GuestProfileController::class);
Route::apiResource('companystate',CompanyStatementController::class);
Route::get('companySatatePagination/{id}',[CompanyStatementController::class, 'companySatatePagination']);
Route::post('pay',[CompanyStatementController::class,'payment']);
Route::post('adv-pay',[CompanyStatementController::class,'AdvPayment']);  
Route::post('credit',[CompanyStatementController::class,'creditNote']);    
Route::post('debit',[CompanyStatementController::class,'debitNote']); 
Route::post('void/{id}',[CompanyStatementController::class,'void']);  
Route::get('state_acc',[CompanyStatementController::class,'statement_acc']); 
Route::get('calc_balance/{id}',[CompanyStatementController::class,'returns']); 
Route::post('guest_filter',[GuestInhouseController::class,'GuestsFilter']); 
Route::apiResource('extend-stay',ExtendStayController::class);

Route::apiResource('oordservicse',OordServiceController::class);
Route::get('oOrdServicesPagination/{id}',[OordServiceController::class, 'oOrdServicesPagination']);

Route::post('change/{id}',[OordServiceController::class,'changeRoom']);
Route::post('return/{id}',[OordServiceController::class,'returnRoom']);
Route::apiResource('ratechange',RateChangeHistoryController::class);
Route::get('ratechangePagination/{id}',[RateChangeHistoryController::class, 'rateChangPagination']);
Route::get('rack',[RoomController::class,'roomRack']);

Route::middleware('tenant')->group(function () {
    // routes
});
