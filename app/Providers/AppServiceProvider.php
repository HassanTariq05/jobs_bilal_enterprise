<?php

namespace App\Providers;

use App\Models\Job;
use App\Observers\JobObserver;

use App\Models\JobInvoice;
use App\Observers\JobInvoiceObserver;


use App\Models\JobInvoiceDetail;
use App\Observers\JobInvoiceDetailObserver;

use App\Models\JobInvoiceContainerBreakup;
use App\Observers\JobInvoiceContainerBreakupObserver;

use App\Models\JobInvoiceReceipt;
use App\Observers\JobInvoiceReceiptObserver;

use App\Models\JobInvoiceReceiptDetail;
use App\Observers\JobInvoiceReceiptDetailObserver;

use App\Models\JobBillPayment;
use App\Observers\JobBillPaymentObserver;

use App\Models\JobBillPaymentDetail;
use App\Observers\JobBillPaymentDetailObserver;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Job::observe(JobObserver::class);

        JobInvoice::observe(JobInvoiceObserver::class);
        JobInvoiceDetail::observe(JobInvoiceDetailObserver::class);
        JobInvoiceReceipt::observe(JobInvoiceReceiptObserver::class);
        JobInvoiceReceiptDetail::observe(JobInvoiceReceiptDetailObserver::class);
        JobBillPayment::observe(JobBillPaymentObserver::class);
        JobBillPaymentDetail::observe(JobBillPaymentDetailObserver::class);
        JobInvoiceContainerBreakup::observe(JobInvoiceContainerBreakupObserver::class);

        Blade::directive('money', function ($amount) {
            return "<?php echo 'Rs.' . number_format($amount, 2); ?>";
            //return "Rs.".number_format($amount, 2);
        });
    }
}
