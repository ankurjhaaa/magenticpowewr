<?php

use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Livewire\Admin\Applications\Index as ApplicationsIndex;
use App\Livewire\Admin\Auth\Login;
use App\Livewire\Admin\Brands\Index as BrandsIndex;
use App\Livewire\Admin\Categories\Index as CategoriesIndex;
use App\Livewire\Admin\CompanyProfile\Edit as CompanyProfileEdit;
use App\Livewire\Admin\ContactMessages\Index as ContactMessagesIndex;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Inquiries\Index as InquiriesIndex;
use App\Livewire\Admin\Products\Index as ProductsIndex;
use App\Livewire\Admin\Products\Manage as ProductsManage;
use App\Livewire\Admin\Specifications\Index as SpecificationsIndex;
use App\Livewire\Admin\TeamMembers\Index as TeamMembersIndex;
use App\Livewire\Admin\Banners\Index as BannersIndex;
use App\Livewire\Admin\Settings\Edit as SettingsEdit;
use App\Livewire\Admin\Faqs\Index as FaqsIndex;
use Illuminate\Support\Facades\Route;

Route::prefix('control-center')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', Login::class)->name('login');
    });

    Route::middleware('auth')->group(function () {
        Route::get('dashboard', Dashboard::class)->name('dashboard');
        Route::get('categories', CategoriesIndex::class)->name('categories.index');
        Route::get('brands', BrandsIndex::class)->name('brands.index');
        Route::get('applications', ApplicationsIndex::class)->name('applications.index');
        Route::get('specifications', SpecificationsIndex::class)->name('specifications.index');
        Route::get('products', ProductsIndex::class)->name('products.index');
        Route::get('products/{product}/manage', ProductsManage::class)->name('products.manage');
        Route::get('inquiries', InquiriesIndex::class)->name('inquiries.index');
        Route::get('contact-messages', ContactMessagesIndex::class)->name('contact-messages.index');
        Route::get('company-profile', CompanyProfileEdit::class)->name('company-profile.edit');
        Route::get('team-members', TeamMembersIndex::class)->name('team-members.index');
        Route::get('banners', BannersIndex::class)->name('banners.index');
        Route::get('settings', SettingsEdit::class)->name('settings.edit');
        Route::get('faqs', FaqsIndex::class)->name('faqs.index');

        Route::post('logout', LogoutController::class)->name('logout');

    });
});
