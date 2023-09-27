<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NutritionController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\Questionnaire;
use App\Http\Controllers\Api\SettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v2/')->as('v2.')->middleware(['api'])->group(function () {

    Route::controller(AuthController::class)->prefix("auth/")->as("auth.")->group(
        function () {
            Route::get("user", "user")->middleware(['auth:sanctum']);
            Route::post("login", "login")->middleware(['validation:login']);
            Route::post("register", "register")->middleware(['validation:register']);
            Route::post("verify", "verify")->middleware(['validation:verify']);
            Route::post("resend-sms-otp", "resendSmsOtp")->middleware(['validation:resendSmsOtp']);
            Route::post("change-password", "changePassword")->middleware(['validation:changePassword', 'auth:sanctum']);
            Route::post("logout", "logout")->middleware(['auth:sanctum']);
        }
    );

    Route::controller(Questionnaire::class)->prefix("questionnaire/")->as("questionnaire.")->middleware(['auth:sanctum'])->group(
        function () {
            Route::get("questions", "getQuestions");
            Route::post('questions', 'submitQuestions')->middleware(['validation:questions']);
            Route::post('create-macronutrients-plan', 'createMacronutrientsPlan')->middleware(['validation:create-macronutrients-plan']);
            Route::get('more-info-body-fat-percentage', 'moreInfoBodyFatPercentage')->middleware(['validation:more-info-body-fat-percentage']);
        }
    );

    Route::controller(ProfileController::class)->prefix("profile/")->as("profile.")->middleware(['auth:sanctum'])->group(
        function () {
            Route::get("user", "user");
            Route::post("update", "update")->middleware(['validation:updateUser']);
            Route::post("update-password", "updatePassword")->middleware(['validation:updatePassword']);
            Route::post("update-profile-picture", "updateProfilePicture")->middleware(['validation:updateProfilePicture']);
        }
    );

    Route::controller(NutritionController::class)->prefix("nutrition")->as("nutrition.")->middleware(['auth:sanctum'])->group(
        function () {
            Route::get("food-exchanges/{type?}", "foodExchanges");
            Route::get("posts/{section}/{tag?}", "posts");
            Route::get("post/{id}", "post");
        }
    );

    Route::controller(SettingsController::class)->prefix('settings/')->as('settings.')->middleware(['auth:sanctum'])->group(
        function () {
            Route::get('get-settings', 'getSettings');
        }
    );
});
