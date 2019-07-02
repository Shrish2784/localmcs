<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 23/08/18
 * Time: 6:55 PM
 */

namespace Devslane\Generator\Exceptions;


class HttpException extends \Symfony\Component\HttpKernel\Exception\HttpException
{


    const      ERROR_CODE_INVALID_CREDENTIALS             = 1;
    const      ERROR_CODE_USER_ALREADY_EXISTS             = 2;
    const      ERROR_CODE_USER_NOT_FOUND                  = 3;
    const      ERROR_CODE_TOKEN_EXPIRED                   = 4;
    const      ERROR_UNAUTHORIZED_ACCESS                  = 5;
    const      ERROR_VERIFY_EMAIL_ADDRESS                 = 6;
    const      ERROR_QUALITY_MEASURE_NOT_FOUND            = 7;
    const      ERROR_PAYER_NOT_FOUND                      = 8;
    const      ERROR_PRACTICE_NOT_FOUND                   = 9;
    const      ERROR_PATIENT_NOT_FOUND                    = 10;
    const      ERROR_VISIT_NOT_FOUND                      = 11;
    const      ERROR_SOURCE_NOT_FOUND                     = 12;
    const      ERROR_PAYER_MEASURE_NOT_FOUND              = 13;
    const      ERROR_PAYER_MEASURE_ALREADY_EXISTS         = 14;
    const      ERROR_MEASURE_ALREADY_ADDED                = 15;
    const      ERROR_APPOINTMENT_NOT_FOUND                = 16;
    const      ERROR_PATIENT_DOES_NOT_BELONG_TO_PRACTICE  = 17;
    const      ERROR_USER_NOT_FOUND                       = 18;
    const      ERROR_USER_ALREADY_EXISTS                  = 19;
    const      ERROR_MEASURE_NOT_ATTACHED                 = 20;
    const      ERROR_CODE_IMAGE_UPLOAD_FAILED             = 21;
    const      ERROR_TEMPLATE_NOT_FOUND                   = 22;
    const      ERROR_CONTACT_NOT_FOUND                    = 23;
    const      ERROR_CODE_INVALID_VERIFICATION_CODE       = 24;
    const      ERROR_DOCTOR_NOT_FOUND                     = 25;
    const      ERROR_REFFERAL_NOT_FOUND                   = 26;
    const      ERROR_SPECIALTY_NOT_FOUND                  = 27;
    const      ERROR_STAFF_NOT_FOUND                      = 28;
    const      ERROR_REFFERAL_STATUS_CANNOT_BE_UPDATED_   = 29;
    const      DOCTOR_ALREADY_MARKED_FAVOURITE            = 30;
    const      ERROR_CHRONIC_DISEASE_NOT_FOUND            = 31;
    const      ERROR_INVALID_SUBCHRONIC_DISEASE           = 32;
    const      ERROR_INCORRECT_PASSWORD                   = 33;
    const      ERROR_CAMPAIGN_NOT_FOUND                   = 34;
    const      ERROR_PATIENT_ALREADY_ADDED                = 35;
    const      ERROR_MEDICINE_NOT_FOUND                   = 36;
    const      ERROR_PATIENT_NOTES_NOT_FOUND              = 37;
    const      ERROR_CAMPAIGN_NEXT_PREV_PATIENT_NOT_FOUND = 38;
    const      ERROR_INVALID_MEDICINE_PATIENTS            = 39;
    const      ERROR_MEDICINE_PATIENTS_ALREADY_ADDED      = 40;
    const      ERROR_NOT_FOUND                            = 41;
    const      ERROR_INVALID_DATE                         = 42;
    const      ERROR_MACHFORM_NOT_FOUND                   = 43;
    const      NOTIFICATION_NOT_FOUND                     = 44;
    const      REMINDER_NOT_FOUND                         = 45;
    const      ERROR_MEDICINE_ALREADY_ADDED               = 46;
    const      ERROR_MEDICINE_NOT_ATTACHED                = 47;

    public function __construct($message, $errorCode, $statusCode = 422)
    {
        parent::__construct($statusCode, $message, null, array(), $errorCode);
    }


}
