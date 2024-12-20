<?php

use App\Http\Controllers\WorkOrdersController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UserPrivilegeController;
use App\Http\Controllers\RolePrivilegeController;

use App\Http\Controllers\PrivilegeCategoryController;
use App\Http\Controllers\PrivilegeGroupController;
use App\Http\Controllers\PrivilegeController;
use App\Http\Controllers\PrivilegeControlRoom;

use App\Http\Controllers\BookingsController;
use App\Http\Controllers\ContainerSizeController;

use App\Http\Controllers\JobController;
use App\Http\Controllers\JobInvoiceController;
use App\Http\Controllers\JobInvoiceDetailController;
use App\Http\Controllers\JobInvoiceContainerBreakupController;
use App\Http\Controllers\JobInvoiceContainerBreakupItemController;
use App\Http\Controllers\JobInvoiceReceiptController;
use App\Http\Controllers\JobBillController;
use App\Http\Controllers\JobBillDetailController;
use App\Http\Controllers\JobBillPaymentController;
use App\Http\Controllers\JobPerformanceController;
use App\Http\Controllers\JobBillContainerBreakupController;
use App\Http\Controllers\JobBillContainerBreakupItemController;

use App\Http\Controllers\JournalVoucherController;
use App\Http\Controllers\VoucherTypeController;

use App\Http\Controllers\TankController;
use App\Http\Controllers\FleetController;
use App\Http\Controllers\FleetTypeController;
use App\Http\Controllers\FleetManufacturerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\FuelTypeController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\UserStatusController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\FuelPurchaseController;
use App\Http\Controllers\FuelIssueController;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AccountNatureController;
use App\Http\Controllers\AccountTitleController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\SalesTaxTerritoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BankAccountController;

use App\Http\Controllers\ReportController;


use App\Http\Controllers\TestController;
use App\Http\Controllers\ActorsController;


Route::redirect('/', '/login');
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/get-login', [UserController::class, 'getLogin'])->name('get-login');
Route::get('/logout', [UserController::class, 'logout']);

Route::get('/test-working', [TestController::class, 'index']);



Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

/*
    Route::get('/jobs/edit/{id}/bill/add', [JobBillController::class, 'create'])->name('create-job-bill');
    Route::post('/jobs/edit/{id}/bill/add', [JobBillController::class, 'store'])->name('store-job-bill');

    Route::get('/jobs/edit/{id}/bill/edit/{bill_id', [JobBillController::class, 'edit'])->name('edit-job-bill');
    Route::post('/jobs/edit/{id}/bill/edit/{bill_id', [JobBillController::class, 'update'])->name('update-job-bill');

        Route::controller(JobBillDetailController::class)->group(function () {
            Route::prefix('/jobs/edit/{id}/bill/{bill_id}/details')->group(function () {
                Route::get('/add', 'create')->name('create-job-bill-detail');
                Route::post('/add', 'store')->name('store-job-bill-detail');
    
                Route::get('/edit/{bill_id}/details/{detail_id}', 'edit')->name('edit-job-bill-detail');
                Route::post('/edit/{bill_id}/details/{detail_id}', 'update')->name('update-job-bill-detail');
            });
            
        });

    Route::get('/jobs/edit/{id}/bill/{bill_id}/details/add', [JobBillDetailController::class, 'create'])->name('create-job-bill-detail');
    Route::post('/jobs/edit/{id}/bill/{bill_id}/details/add', [JobBillDetailController::class, 'store'])->name('store-job-bill-detail');

    Route::get('/jobs/edit/{id}/bill/edit/{bill_id', [JobBillDetailController::class, 'edit'])->name('edit-job-bill-detail');
    Route::post('/jobs/edit/{id}/bill/edit/{bill_id', [JobBillDetailController::class, 'update'])->name('update-job-bill-detail');
*/

    Route::controller(BookingsController::class)->group(function () {
        Route::prefix('/bookings')->group(function () {
            Route::get('/', 'index')->name('bookings');
            Route::post('/', 'index')->name('search');
            // Route::get('/job-queue', 'job_queue')->name('job-queue');
            Route::post('/get-booking-containers', 'booking_containers')->name('job-queue');

            Route::get('/add', 'create')->name('create-booking');
            Route::post('/add', 'store')->name('store-booking');
            Route::post('/add-manually', 'store_manually')->name('store-booking-manually'); 
            Route::post('/update-containers-manually', 'update_containers_manually')->name('update-containers-manually'); 
            Route::get('/edit/{id}', 'edit')->name('edit-booking');
            Route::post('/edit/{id}', 'update')->name('update-booking');

            Route::get('/trash/{id}', 'trash')->name('trash-booking');
            Route::get('/restore/{id}', 'restore')->name('restore-booking');
        });
    });


    Route::controller(JobController::class)->group(function () {
        Route::prefix('/jobs')->group(function () {
            Route::get('/', 'index')->name('jobs');
            Route::post('/', 'index')->name('search');



            Route::get('/add', 'create')->name('create-job');
            Route::post('/add', 'store')->name('store-job');

            Route::get('/edit/{id}', 'edit')->name('edit-job');
            Route::post('/edit/{id}', 'update')->name('update-job');

            Route::get('/trash/{id}', 'trash')->name('trash-job');
            Route::get('/restore/{id}', 'restore')->name('restore-job');
        });
    });

    Route::controller(JobInvoiceController::class)->group(function () {
        Route::prefix('/jobs/edit/{id}/invoice')->group(function () {
            Route::get('/', 'index')->name('job_invoices');

            Route::get('/add', 'create')->name('create-job-invoice');
            Route::post('/add', 'store')->name('store-job-invoice');

            Route::get('/edit/{inv_id}', 'edit')->name('edit-job-invoice');
            Route::post('/edit/{inv_id}', 'update')->name('update-job-invoice');
            
        });
        Route::get('/job/invoice/trash/{id}', 'trash')->name('trash-job-invoice');
        Route::get('/job/invoice/restore/{id}', 'restore')->name('restore-job-invoice');

        Route::get('/job/invoice/generate-pdf/{id}', 'generate_invoice_pdf')->name('invoice-generate-pdf');
        Route::post('/job/invoice/generate-pdf/{id}', 'generate_invoice_pdf')->name('invoice-generate-pdf');
    });

    Route::get('/get-job-invoice-receipts/{id}', [JobInvoiceController::class, 'get_job_invoice_receipts'])->name('get-job-invoice-receipts');

    Route::controller(JobInvoiceDetailController::class)->group(function () {
        Route::prefix('/jobs/edit/{id}/invoice/edit/{inv_id}/details')->group(function () {
            Route::get('/add', 'create')->name('create-job-invoice-detail');
            Route::post('/add', 'store')->name('store-job-invoice-detail');
            Route::get('/edit/{detail_id}', 'edit')->name('edit-job-invoice-detail');
            Route::post('/edit/{detail_id}', 'update')->name('update-job-invoice-detail');  

            Route::post('/store-container-breakup-invoice-item', 'store_container_breakup_invoice_item')->name('store-container-breakup-invoice-item');
        });

        Route::get('/job/invoice/detail/trash/{id}', 'trash')->name('trash-job-invoice-detail');
        Route::get('/job/invoice/detail/restore/{id}', 'restore')->name('restore-job-invoice-detail');
    });
    Route::controller(JobInvoiceContainerBreakupController::class)->group(function () {

        Route::prefix('/jobs/edit/{id}/invoice/edit/{inv_id}/invoice-container-breakup')->group(function () {

            Route::get('/add', 'create')->name('create-job-invoice-detail-container-breakup');
            Route::post('/add', 'create')->name('create-job-invoice-detail-container-breakup');

            Route::post('/store', 'store')->name('store-job-invoice-detail-container-breakup');

            Route::get('/edit/{inv_detail_id}/{container_item_code}', 'edit')->name('edit-job-invoice-detail-container-breakup');
            Route::post('/edit/{inv_detail_id}/{container_item_code}', 'update')->name('update-job-invoice-detail-container-breakup');

            //Route::get('/trash/{breakup_id}', 'trash')->name('trash-job-invoice-detail-container-breakup');
            //Route::get('/restore/{breakup_id}', 'restore')->name('restore-job-invoice-detail-container-breakup');

            Route::get('/download/{cic}', 'download')->name('download-job-invoice-detail-container-breakup');

        });
        Route::get('/job/invoice/detail/container-breakup/trash/{id}/{cic}', 'trash')->name('trash-job-invoice-detail-container-breakup');
        Route::get('/job/invoice/detail/container-breakup/restore/{id}/{cic}', 'restore')->name('restore-job-invoice-detail-container-breakup');
        Route::get('/job/invoice/detail/container-breakup/destroy/{id}', 'destroy')->name('destroy-job-invoice-detail-container-breakup');
    });        
    Route::controller(JobInvoiceContainerBreakupItemController::class)->group(function () {

        Route::post('/job/invoice/detail/container-breakup-item/update-items-rate', 'update_items_rate')->name('update-invoice-items-rate');
        Route::get('/job/invoice/detail/container-breakup-item/trash/{id}/{cic}', 'trash')->name('trash-job-invoice-detail-container-breakup-item');
        Route::get('/job/invoice/detail/container-breakup-item/restore/{id}/{cic}', 'restore')->name('restore-job-invoice-detail-container-breakup-item');

    });        
    Route::controller(JobInvoiceReceiptController::class)->group(function () {
        Route::prefix('/jobs/receipts')->group(function () {
            Route::get('/', 'index')->name('job-receipts');

            Route::get('/add', 'create')->name('create-job-receipt');
            Route::post('/add', 'store')->name('store-job-receipt');

            Route::get('/edit/{id}', 'edit')->name('edit-job-receipt');
            Route::post('/edit/{id}', 'update')->name('update-job-receipt');

            Route::post('/getOutstandingInvoices', 'getOutstandingInvoices');

            Route::get('/trash/{id}', 'trash')->name('trash-job-receipt');
            Route::get('/restore/{id}', 'restore')->name('restore-job-receipt');
        });
    });

    Route::controller(JobBillController::class)->group(function () {
        Route::prefix('/jobs/edit/{id}/bill')->group(function () {
            Route::get('/add', 'create')->name('create-job-bill');
            Route::post('/add', 'store')->name('store-job-bill');
            Route::get('/edit/{bill_id}', 'edit')->name('edit-job-bill');
            Route::post('/edit/{bill_id}', 'update')->name('update-job-bill');
        });
        Route::get('/job/bill/trash/{id}', 'trash')->name('trash-job-bill');
        Route::get('/job/bill/restore/{id}', 'restore')->name('restore-job-bill');
    });
    
    Route::get('/get-job-bill-payments/{id}', [JobBillController::class, 'get_job_bill_payments'])->name('get-job-bill-payments');

    Route::controller(JobBillDetailController::class)->group(function () {
        Route::prefix('/jobs/edit/{id}/bill/edit/{bill_id}/details')->group(function () {
            Route::get('/add', 'create')->name('create-job-bill-detail');
            Route::post('/add', 'store')->name('store-job-bill-detail');
            Route::get('/edit/{detail_id}', 'edit')->name('edit-job-bill-detail');
            Route::post('/edit/{detail_id}', 'update')->name('update-job-bill-detail');

            Route::post('/store-container-breakup-bill-item', 'store_container_breakup_bill_item')->name('store-container-breakup-bill-item');
        });
        Route::get('/job/bill/detail/trash/{id}', 'trash')->name('trash-job-bill-detail');
        Route::get('/job/bill/detail/restore/{id}', 'restore')->name('restore-job-bill-detail');
    });
    Route::controller(JobBillContainerBreakupController::class)->group(function () {
        Route::prefix('/jobs/edit/{id}/bill/edit/{bill_id}/bill-container-breakup')->group(function () {

            Route::get('/add', 'create')->name('create-job-bill-detail-container-breakup');
            Route::post('/add', 'create')->name('create-job-bill-detail-container-breakup');

            Route::post('/store', 'store')->name('store-job-bill-detail-container-breakup');

            Route::get('/edit/{bill_detail_id}/{container_item_code}', 'edit')->name('edit-job-bill-detail-container-breakup');
            Route::post('/edit/{bill_detail_id}/{container_item_code}', 'update')->name('update-job-bill-detail-container-breakup');

            //Route::get('/trash/{breakup_id}', 'trash')->name('trash-job-bill-detail-container-breakup');
            //Route::get('/restore/{breakup_id}', 'restore')->name('restore-job-bill-detail-container-breakup');

        });
        Route::get('/job/bill/detail/container-breakup/trash/{id}/{cic}', 'trash')->name('trash-job-bill-detail-container-breakup');
        Route::get('/job/bill/detail/container-breakup/restore/{id}/{cic}', 'restore')->name('restore-job-bill-detail-container-breakup');
        Route::get('/job/bill/detail/container-breakup/destroy/{id}', 'destroy')->name('destroy-job-bill-detail-container-breakup');
    });        
    Route::controller(JobBillContainerBreakupItemController::class)->group(function () {

        Route::post('/job/bill/detail/container-breakup-item/update-items-rate', 'update_items_rate')->name('update-bill-items-rate');
        Route::get('/job/bill/detail/container-breakup-item/trash/{id}/{cic}', 'trash')->name('trash-job-bill-detail-container-breakup-item');
        Route::get('/job/bill/detail/container-breakup-item/restore/{id}/{cic}', 'restore')->name('restore-job-bill-detail-container-breakup-item');

    });   
    Route::controller(JobBillPaymentController::class)->group(function () {
        Route::prefix('/jobs/payments')->group(function () {
            Route::get('/', 'index')->name('job-payments');

            Route::get('/add', 'create')->name('create-job-payment');
            Route::post('/add', 'store')->name('store-job-payment');

            Route::get('/edit/{id}', 'edit')->name('edit-job-payment');
            Route::post('/edit/{id}', 'update')->name('update-job-payment');

            Route::post('/getOutstandingBills', 'getOutstandingBills');

            Route::get('/trash/{id}', 'trash')->name('trash-job-payment');
            Route::get('/restore/{id}', 'restore')->name('restore-job-payment');
        });
    });

    Route::controller(WorkOrdersController::class)->group(function () {
        Route::prefix('/work-orders')->group(function () {
            Route::get('/all', 'index')->name("work-orders");
            Route::get('/post/{id}', 'postWorkOrder')->name("post-work-order");
            Route::post('/assign/{jobId}', 'assignWorkOrders')->name("assign-work-orders");
        });
    });

    Route::controller(JobPerformanceController::class)->group(function () {
        Route::prefix('/jobs/edit/{id}/performance')->group(function () {
            Route::get('/', 'index')->name('job-performance');
            Route::get('/new', 'index2')->name('job-performance-new');
            
            Route::get('/add', 'create')->name('create-job-performance');
            Route::post('/upload-job-performance-sheet', 'upload_job_performance_sheet')->name('upload-job-performance-sheet');
            Route::post('/add', 'store')->name('store-job-performance');
            Route::get('/show/{rid}', 'show')->name('show-job-performance');
            
            Route::get('/containers/{bookingNumber}', 'getContainers')->name('show-containers');
            Route::post('/containers/{bookingNumber}', 'updateContainers')->name('update-containers');


            Route::get('/download-locations-master', 'download_locations_master')->name('download-locations-master');
            Route::get('/download-parties-master', 'download_parties_master')->name('download-parties-master');
            /*
            Route::get('/edit/{id}', 'edit')->name('edit-job');
            Route::post('/edit/{id}', 'update')->name('update-job');

            Route::get('/trash/{id}', 'trash')->name('trash-job');
            Route::get('/restore/{id}', 'restore')->name('restore-job');
            */
        });
    });



    Route::controller(TankController::class)->group(function () {
        Route::prefix('/tanks')->group(function () {
            Route::get('/', 'index')->name('tanks');

            Route::get('/add', 'create')->name('create-tank');
            Route::post('/add', 'store')->name('store-tank');

            Route::get('/edit/{id}', 'edit')->name('edit-tank');
            Route::post('/edit/{id}', 'update')->name('update-tank');

            Route::get('/trash/{id}', 'trash')->name('trash-tank');
            Route::get('/restore/{id}', 'restore')->name('restore-tank');
        });
    });

    Route::controller(FleetController::class)->group(function () {
        Route::prefix('/fleets')->group(function () {
            Route::get('/', 'index')->name('fleets');

            Route::get('/add', 'create')->name('create-fleet');
            Route::post('/add', 'store')->name('store-fleet');

            Route::get('/edit/{id}', 'edit')->name('edit-fleet');
            Route::post('/edit/{id}', 'update')->name('update-fleet');

            Route::get('/trash/{id}', 'trash')->name('trash-fleet');
            Route::get('/restore/{id}', 'restore')->name('restore-fleet');
        });
    });

    Route::controller(FleetManufacturerController::class)->group(function () {
        Route::prefix('/fleets/manufacturers')->group(function () {
            Route::get('/', 'index')->name('fleet-manufacturers');

            Route::get('/add', 'create')->name('create-fleet-manufacturer');
            Route::post('/add', 'store')->name('store-fleet-manufacturer');

            Route::get('/edit/{id}', 'edit')->name('edit-fleet-manufacturer');
            Route::post('/edit/{id}', 'update')->name('update-fleet-manufacturer');

            Route::get('/trash/{id}', 'trash')->name('trash-fleet-manufacturer');
            Route::get('/restore/{id}', 'restore')->name('restore-fleet-manufacturer');
        });
    });

    Route::controller(FleetTypeController::class)->group(function () {
        Route::prefix('/fleets/types')->group(function () {
            Route::get('/', 'index')->name('fleet-types');

            Route::get('/add', 'create')->name('create-fleet-type');
            Route::post('/add', 'store')->name('store-fleet-type');

            Route::get('/edit/{id}', 'edit')->name('edit-fleet-type');
            Route::post('/edit/{id}', 'update')->name('update-fleet-type');

            Route::get('/trash/{id}', 'trash')->name('trash-fleet-type');
            Route::get('/restore/{id}', 'restore')->name('restore-fleet-type');
        });
    });


    Route::controller(UserStatusController::class)->group(function () {
        Route::prefix('/users-status')->group(function () {
            Route::get('/', 'index')->name('users-status');

            Route::get('/add', 'create')->name('create-user-status');
            Route::post('/add', 'store')->name('store-user-status');

            Route::get('/edit/{id}', 'edit')->name('edit-user-status');
            Route::post('/edit/{id}', 'update')->name('update-user-status');

            Route::get('/trash/{id}', 'trash')->name('trash-user-status');
            Route::get('/restore/{id}', 'restore')->name('restore-user-status');
        });
    });

    Route::controller(UserController::class)->group(function () {
        Route::prefix('/users')->group(function () {
            Route::get('/', 'index')->name('users');

            Route::get('/add', 'create')->name('create-user');
            Route::post('/add', 'store')->name('store-user');

            Route::get('/edit/{id}', 'edit')->name('edit-user');
            Route::post('/edit/{id}', 'update')->name('update-user');

            Route::get('/trash/{id}', 'trash')->name('trash-user');
            Route::get('/restore/{id}', 'restore')->name('restore-user');
        });
    });

    Route::controller(UserRoleController::class)->group(function () {
        Route::prefix('/user-roles')->group(function () {
            Route::get('/', 'index')->name('user-roles');

            Route::get('/add', 'create')->name('create-user-role');
            Route::post('/add', 'store')->name('store-user-role');

            Route::get('/edit/{id}', 'edit')->name('edit-user-role');
            Route::post('/edit/{id}', 'update')->name('update-user-role');
        });
    });



    // PRIVILEGES CONTROL ROOM - Starting

    //use App\Http\Controllers\PrivilegeCategoryController;
    //use App\Http\Controllers\PrivilegeGroupController;
    //use App\Http\Controllers\PrivilegeController;

    Route::controller(PrivilegeControlRoom::class)->group(function () {
        Route::prefix('/privilege-control-room')->group(function () {
            Route::get('/', 'index')->name('privilege-control-room');
            Route::get('/generate-privilege-json', 'generate_privilege_json')->name('generate-privilege-json');
        });
    });
    
    Route::controller(PrivilegeCategoryController::class)->group(function () {
        Route::prefix('/privilege-control-room/category')->group(function () {
            Route::get('/add', 'create')->name('create-privilege-category');            
            Route::post('/add', 'store')->name('store-privilege-category');
            Route::get('/edit/{id}', 'edit')->name('edit-privilege-category');
            Route::post('/edit/{id}', 'update')->name('update-privilege-category');
        });
    });

    Route::controller(PrivilegeGroupController::class)->group(function () {
        Route::prefix('/privilege-control-room/group')->group(function () {
            Route::get('/add', 'create')->name('create-privilege-group');            
            Route::post('/add', 'store')->name('store-privilege-group');
            Route::get('/edit/{id}', 'edit')->name('edit-privilege-group');
            Route::post('/edit/{id}', 'update')->name('update-privilege-group');
        });
    });

    Route::controller(PrivilegeController::class)->group(function () {
        Route::prefix('/privilege-control-room/privilege')->group(function () {
            Route::get('/add', 'create')->name('create-privilege');            
            Route::post('/add', 'store')->name('store-privilege');
            Route::get('/edit/{id}', 'edit')->name('edit-privilege');
            Route::post('/edit/{id}', 'update')->name('update-privilege');
        });
    });

    // PRIVILEGES CONTROL ROOM - Ending

    /*
    Route::controller(UserPrivilegeController::class)->group(function () {
        Route::prefix('/user/privileges')->group(function () {
            Route::get('/{id}', 'edit')->name('user-privileges');
            Route::post('/{id}', 'update')->name('update-user-privileges');
        });
    });
    */

    Route::controller(RolePrivilegeController::class)->group(function () {
        Route::prefix('/role/privileges')->group(function () {
            Route::get('/{id}', 'edit')->name('role-privileges');
            Route::post('/{id}', 'update')->name('update-role-privileges');
        });
    });


    Route::controller(ContainerSizeController::class)->group(function () {
        Route::prefix('/container-sizes')->group(function () {
            Route::get('/', 'index')->name('container-sizes');

            Route::get('/add', 'create')->name('create-container-size');
            Route::post('/add', 'store')->name('store-container-size');

            Route::get('/edit/{id}', 'edit')->name('edit-container-size');
            Route::post('/edit/{id}', 'update')->name('update-container-size');

            Route::get('/trash/{id}', 'trash')->name('trash-container-size');
            Route::get('/restore/{id}', 'restore')->name('restore-container-size');
        });
    });

    Route::controller(LocationController::class)->group(function () {
        Route::prefix('/locations')->group(function () {
            Route::get('/', 'index')->name('locations');

            Route::get('/add', 'create')->name('create-location');
            Route::post('/add', 'store')->name('store-location');

            Route::get('/edit/{id}', 'edit')->name('edit-location');
            Route::post('/edit/{id}', 'update')->name('update-location');

            Route::get('/trash/{id}', 'trash')->name('trash-location');
            Route::get('/restore/{id}', 'restore')->name('restore-location');
        });
    });

    Route::controller(DesignationController::class)->group(function () {
        Route::prefix('/users/designations')->group(function () {
            Route::get('/', 'index')->name('designations');

            Route::get('/add', 'create')->name('create-designation');
            Route::post('/add', 'store')->name('store-designation');

            Route::get('/edit/{id}', 'edit')->name('edit-designation');
            Route::post('/edit/{id}', 'update')->name('update-designation');

            Route::get('/trash/{id}', 'trash')->name('trash-designation');
            Route::get('/restore/{id}', 'restore')->name('restore-designation');
        });
    });


    Route::controller(FuelTypeController::class)->group(function () {
        Route::prefix('/fuel-types')->group(function () {
            Route::get('/', 'index')->name('fuel-types');

            Route::get('/add', 'create')->name('create-fuel-type');
            Route::post('/add', 'store')->name('store-fuel-type');

            Route::get('/edit/{id}', 'edit')->name('edit-fuel-type');
            Route::post('/edit/{id}', 'update')->name('update-fuel-type');

            Route::get('/trash/{id}', 'trash')->name('trash-fuel-type');
            Route::get('/restore/{id}', 'restore')->name('restore-fuel-type');
        });
    });
    Route::controller(ActorsController::class)->group(function () {
        Route::prefix('/actors')->group(function () {
            Route::get('/', 'index')->name('actors');

            Route::get('/add', 'create')->name('create-actor');
            Route::post('/add', 'store')->name('store-actor');

            Route::get('/edit/{id}', 'edit')->name('edit-actor');
            Route::post('/edit/{id}', 'update')->name('update-actor');

            Route::get('/trash/{id}', 'trash')->name('trash-actor');
            Route::get('/restore/{id}', 'restore')->name('restore-actor');
        });
    });

    Route::controller(OperationController::class)->group(function () {
        Route::prefix('/operations')->group(function () {
            Route::get('/', 'index')->name('operations');

            Route::get('/add', 'create')->name('create-operation');
            Route::post('/add', 'store')->name('store-operation');

            Route::get('/edit/{id}', 'edit')->name('edit-operation');
            Route::post('/edit/{id}', 'update')->name('update-operation');

            Route::get('/trash/{id}', 'trash')->name('trash-operation');
            Route::get('/restore/{id}', 'restore')->name('restore-operation');
        });
    });


    Route::controller(FuelPurchaseController::class)->group(function () {
        Route::prefix('/fuel-purchases')->group(function () {
            Route::get('/', 'index')->name('fuel-purchases');

            Route::get('/add', 'create')->name('create-fuel-purchase');
            Route::post('/add', 'store')->name('store-fuel-purchase');

            Route::get('/edit/{id}', 'edit')->name('edit-fuel-purchase');
            Route::post('/edit/{id}', 'update')->name('update-fuel-purchase');

            Route::get('/trash/{id}', 'trash')->name('trash-fuel-purchase');
            Route::get('/restore/{id}', 'restore')->name('restore-fuel-purchase');
        });
    });
    Route::controller(FuelIssueController::class)->group(function () {
        Route::prefix('/fuel-issue')->group(function () {
            Route::get('/', 'index')->name('fuel-issue');

            Route::get('/add', 'create')->name('create-fuel-issue');
            Route::post('/add', 'store')->name('store-fuel-issue');

            Route::get('/edit/{id}', 'edit')->name('edit-fuel-issue');
            Route::post('/edit/{id}', 'update')->name('update-fuel-issue');

            Route::get('/trash/{id}', 'trash')->name('trash-fuel-issue');
            Route::get('/restore/{id}', 'restore')->name('restore-fuel-issue');
        });
    });


    Route::controller(ProjectController::class)->group(function () {
        Route::prefix('/projects')->group(function () {
            Route::get('/', 'index')->name('projects');

            Route::get('/add', 'create')->name('create-project');
            Route::post('/add', 'store')->name('store-project');

            Route::get('/edit/{id}', 'edit')->name('edit-project');
            Route::post('/edit/{id}', 'update')->name('update-project');

            Route::get('/trash/{id}', 'trash')->name('trash-project');
            Route::get('/restore/{id}', 'restore')->name('restore-project');
        });
    });    
    Route::controller(AccountNatureController::class)->group(function () {
        Route::prefix('/account-natures')->group(function () {
            Route::get('/', 'index')->name('account-natures');

            Route::get('/add', 'create')->name('create-account-nature');
            Route::post('/add', 'store')->name('store-account-nature');

            Route::get('/edit/{id}', 'edit')->name('edit-account-nature');
            Route::post('/edit/{id}', 'update')->name('update-account-nature');

            Route::get('/trash/{id}', 'trash')->name('trash-account-nature');
            Route::get('/restore/{id}', 'restore')->name('restore-account-nature');
        });
    });    
    Route::controller(AccountTitleController::class)->group(function () {
        Route::prefix('/account-titles')->group(function () {
            Route::get('/', 'index')->name('account-titles');

            Route::get('/add', 'create')->name('create-account-title');
            Route::post('/add', 'store')->name('store-account-title');

            Route::get('/edit/{id}', 'edit')->name('edit-account-title');
            Route::post('/edit/{id}', 'update')->name('update-account-title');

            Route::get('/trash/{id}', 'trash')->name('trash-account-title');
            Route::get('/restore/{id}', 'restore')->name('restore-account-title');
        });
    });   
    Route::controller(JobTypeController::class)->group(function () {
        Route::prefix('/job-types')->group(function () {
            Route::get('/', 'index')->name('job-types');

            Route::get('/add', 'create')->name('create-job-type');
            Route::post('/add', 'store')->name('store-job-type');

            Route::get('/edit/{id}', 'edit')->name('edit-job-type');
            Route::post('/edit/{id}', 'update')->name('update-job-type');

            Route::get('/trash/{id}', 'trash')->name('trash-job-type');
            Route::get('/restore/{id}', 'restore')->name('restore-job-type');
        });
    });  
    Route::controller(SalesTaxTerritoryController::class)->group(function () {
        Route::prefix('/sales-tax-territories')->group(function () {
            Route::get('/', 'index')->name('sales-tax-territories');

            Route::get('/add', 'create')->name('create-sales-tax-territory');
            Route::post('/add', 'store')->name('store-sales-tax-territory');

            Route::get('/edit/{id}', 'edit')->name('edit-sales-tax-territory');
            Route::post('/edit/{id}', 'update')->name('update-sales-tax-territory');

            Route::get('/trash/{id}', 'trash')->name('trash-sales-tax-territory');
            Route::get('/restore/{id}', 'restore')->name('restore-sales-tax-territory');
        });
    });      
    Route::controller(CompanyController::class)->group(function () {
        Route::prefix('/companies')->group(function () {
            Route::get('/', 'index')->name('companies');

            Route::get('/add', 'create')->name('create-company');
            Route::post('/add', 'store')->name('store-company');

            Route::get('/edit/{id}', 'edit')->name('edit-company');
            Route::post('/edit/{id}', 'update')->name('update-company');

            Route::get('/trash/{id}', 'trash')->name('trash-company');
            Route::get('/restore/{id}', 'restore')->name('restore-company');
        });
    });    
    Route::controller(PartyController::class)->group(function () {
        Route::prefix('/parties')->group(function () {
            Route::get('/', 'index')->name('parties');

            Route::get('/add', 'create')->name('create-party');
            Route::post('/add', 'store')->name('store-party');

            Route::get('/edit/{id}', 'edit')->name('edit-party');
            Route::post('/edit/{id}', 'update')->name('update-party');

            Route::get('/trash/{id}', 'trash')->name('trash-party');
            Route::get('/restore/{id}', 'restore')->name('restore-party');
        });
    }); 
    Route::controller(BankController::class)->group(function () {
        Route::prefix('/banks')->group(function () {
            Route::get('/', 'index')->name('banks');

            Route::get('/add', 'create')->name('create-bank');
            Route::post('/add', 'store')->name('store-bank');

            Route::get('/edit/{id}', 'edit')->name('edit-bank');
            Route::post('/edit/{id}', 'update')->name('update-bank');

            Route::get('/trash/{id}', 'trash')->name('trash-bank');
            Route::get('/restore/{id}', 'restore')->name('restore-bank');
        });
    }); 
    Route::controller(BankAccountController::class)->group(function () {
        Route::prefix('/bank-accounts')->group(function () {
            Route::get('/', 'index')->name('bank-accounts');

            Route::get('/add', 'create')->name('create-bank-account');
            Route::post('/add', 'store')->name('store-bank-account');

            Route::get('/edit/{id}', 'edit')->name('edit-bank-account');
            Route::post('/edit/{id}', 'update')->name('update-bank-account');

            Route::get('/trash/{id}', 'trash')->name('trash-bank-account');
            Route::get('/restore/{id}', 'restore')->name('restore-bank-account');
        });
    });     


    Route::controller(ReportController::class)->group(function () {
        Route::prefix('/reports')->group(function () {

            Route::get('/customer-ledger', 'customer_ledger')->name('customer-ledger');
            Route::post('/customer-ledger', 'customer_ledger')->name('customer-ledger');

            Route::get('/vendor-ledger', 'vendor_ledger')->name('vendor-ledger');
            Route::post('/vendor-ledger', 'vendor_ledger')->name('vendor-ledger');

            Route::get('/general-ledger', 'general_ledger')->name('general-ledger');
            Route::post('/general-ledger', 'general_ledger')->name('general-ledger');

            Route::get('/bank-ledger', 'bank_ledger')->name('bank-ledger');
            Route::post('/bank-ledger', 'bank_ledger')->name('bank-ledger');

            Route::get('/party-wise-surplus-deficit', 'party_wise_surplus_deficit')->name('party-wise-surplus-deficit');
            Route::post('/party-wise-surplus-deficit', 'party_wise_surplus_deficit')->name('party-wise-surplus-deficit');

            Route::get('/job-wise-pnl', 'job_wise_pnl')->name('job-wise-pnl');
            Route::post('/job-wise-pnl', 'job_wise_pnl')->name('job-wise-pnl');

            /*
            Route::get('/vendors', 'vendors')->name('vendors');
            Route::post('/vendors', 'vendors')->name('vendors');

            Route::get('/customers', 'customers')->name('customers');
            Route::post('/customers', 'customers')->name('customers');


            Route::get('/transactions', 'transactions')->name('transactions');
            Route::post('/transactions', 'transactions')->name('transactions');

            Route::get('/collection', 'collection')->name('collection');
            Route::post('/collection', 'collection')->name('collection');

            Route::get('/adjustment', 'adjustment')->name('adjustment');
            Route::post('/adjustment', 'adjustment')->name('adjustment');

            */

        });
    }); 


    Route::controller(JournalVoucherController::class)->group(function () {
        Route::prefix('/journal-vouchers')->group(function () {
            Route::get('/', 'index')->name('journal-vouchers');

            Route::get('/add', 'create')->name('create-journal-voucher');
            Route::post('/add', 'store')->name('store-journal-voucher');

            Route::get('/edit/{id}', 'edit')->name('edit-journal-voucher');
            Route::post('/edit/{id}', 'update')->name('update-journal-voucher');

            Route::get('/trash/{id}', 'trash')->name('trash-journal-voucher');
            Route::get('/restore/{id}', 'restore')->name('restore-journal-voucher');
        });
    });     


    Route::controller(VoucherTypeController::class)->group(function () {
        Route::prefix('/voucher/types')->group(function () {
            Route::get('/', 'index')->name('voucher-types');

            //Route::get('/add', 'create')->name('create-voucher-type');
            //Route::post('/add', 'store')->name('store-voucher-type');

            //Route::get('/edit/{id}', 'edit')->name('edit-journal-voucher');
            //Route::post('/edit/{id}', 'update')->name('update-journal-voucher');

            //Route::get('/trash/{id}', 'trash')->name('trash-journal-voucher');
            //Route::get('/restore/{id}', 'restore')->name('restore-journal-voucher');
        });
    });     


});
