<?php

namespace Modules\HumanResources\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\HumanResources\Entities\Holiday;

class SundayHolidayRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $sundayHoliday = Holiday::where('holidayyear', $value)->where('remark', 'Sunday Holiday')->get();
        return (count($sundayHoliday) > 0 ? false : true);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The Sunday holidays with this year input has existed';
    }
}
