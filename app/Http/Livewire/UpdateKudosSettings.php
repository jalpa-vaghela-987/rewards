<?php

namespace App\Http\Livewire;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateKudosSettings extends Component
{
    public $customized_number_of_kudos;

    public $level_1_points_to_give;
    public $level_2_points_to_give;
    public $level_3_points_to_give;
    public $level_4_points_to_give;
    public $level_5_points_to_give;
    public $standard_kudos_value;
    public $super_kudos_value;
    public $birthday_kudos_value;
    public $anniversary_kudos_value;
    public $default_kudos_amount;

    public $default_level_1_points_to_give = 500;
    public $default_level_2_points_to_give = 2000;
    public $default_level_3_points_to_give = 5000;
    public $default_level_4_points_to_give = 7500;
    public $default_level_5_points_to_give = 10000;
    public $default_standard_kudos_value = 500;
    public $default_super_kudos_value = 1000;
    public $default_birthday_kudos_value = 500;
    public $default_anniversary_kudos_value = 500;
    public $default_kudos_amount_value = 5000;

    public function mount()
    {
        $company = Auth::user()->company;

        $this->customized_number_of_kudos =
            $company->customized_number_of_kudos;

        $this->level_1_points_to_give = $company->level_1_points_to_give;
        $this->level_2_points_to_give = $company->level_2_points_to_give;
        $this->level_3_points_to_give = $company->level_3_points_to_give;
        $this->level_4_points_to_give = $company->level_4_points_to_give;
        $this->level_5_points_to_give = $company->level_5_points_to_give;
        $this->standard_kudos_value = $company->standard_value;
        $this->super_kudos_value = $company->super_value;
        $this->birthday_kudos_value = $company->birthday_value;
        $this->anniversary_kudos_value = $company->anniversary_value;
        $this->default_kudos_amount = $company->default_kudos_amount;
    }

    public function render()
    {
        $company_id = Auth::user()->company_id;
        $company_data = Company::where('id', $company_id)->first();
        $this->kudos = $company_data->monthly_points_to_give;

        return view('livewire.update-kudos-settings');
    }

    public function updateKudos()
    {
        $validated = $this->validate(
            [
                'customized_number_of_kudos' => 'required|numeric|gt:0|max:100000',

                'level_1_points_to_give' => 'required|integer|gte:0|min:1|max:100000',
                'level_2_points_to_give' => 'required|integer|gte:0|min:1|max:100000',
                'level_3_points_to_give' => 'required|integer|gte:0|min:1|max:100000',
                'level_4_points_to_give' => 'required|integer|gte:0|min:1|max:100000',
                'level_5_points_to_give' => 'required|integer|gte:0|min:1|max:100000',
                'standard_kudos_value' => 'required|integer|gte:0|min:1|max:100000',
                'super_kudos_value' => 'required|integer|gte:0|min:1|max:100000',
                'birthday_kudos_value' => 'required|integer|gte:0|min:1|max:100000',
                'anniversary_kudos_value' => 'required|integer|gte:0|min:1|max:100000',
                'default_kudos_amount' => 'required|integer|gte:0|min:1|max:100000',
            ],
            [],
            [
                'customized_number_of_kudos' => 'Customized Number of '.getReplacedWordOfKudos(),

                'level_1_points_to_give' => 'Monthly '.getReplacedWordOfKudos().' allowance',
                'level_2_points_to_give' => 'Monthly '.getReplacedWordOfKudos().' allowance',
                'level_3_points_to_give' => 'Monthly '.getReplacedWordOfKudos().' allowance',
                'level_4_points_to_give' => 'Monthly '.getReplacedWordOfKudos().' allowance',
                'level_5_points_to_give' => 'Monthly '.getReplacedWordOfKudos().' allowance',
                'standard_kudos_value' => 'Standard '.getReplacedWordOfKudos().' value',
                'super_kudos_value' => 'Super '.getReplacedWordOfKudos().' value',
                'birthday_kudos_value' => 'Birthday '.getReplacedWordOfKudos().' value',
                'anniversary_kudos_value' => 'Anniversary '.getReplacedWordOfKudos().' value',
                'default_kudos_amount' => 'Default '.getReplacedWordOfKudos().' Amount',
            ]
        );

        $company = Auth::user()->company;

        $company->customized_number_of_kudos =
            $validated['customized_number_of_kudos'];

        $company->level_1_points_to_give = $validated['level_1_points_to_give'];
        $company->level_2_points_to_give = $validated['level_2_points_to_give'];
        $company->level_3_points_to_give = $validated['level_3_points_to_give'];
        $company->level_4_points_to_give = $validated['level_4_points_to_give'];
        $company->level_5_points_to_give = $validated['level_5_points_to_give'];
        $company->standard_value = $validated['standard_kudos_value'];
        $company->super_value = $validated['super_kudos_value'];
        $company->birthday_value = $validated['birthday_kudos_value'];
        $company->anniversary_value = $validated['anniversary_kudos_value'];
        $company->default_kudos_amount = $validated['default_kudos_amount'];

        $saved = $company->save();

        //$company_data = Company :: where('id', $company_id)->update(['monthly_points_to_give'=>$data['kudos']]);

        if ($saved) {
            $this->emit('saved');
            $this->emit('refresh-navigation-menu');
        }
    }

    public function updatedCustomizedNumberOfKudos($value = 0)
    {
        return false;

        $valueToBeDivideWith = $value ? ($value * 1) / 100 : 0;

        $this->level_1_points_to_give =
            $this->default_level_1_points_to_give * $valueToBeDivideWith;
        $this->level_2_points_to_give =
            $this->default_level_2_points_to_give * $valueToBeDivideWith;
        $this->level_3_points_to_give =
            $this->default_level_3_points_to_give * $valueToBeDivideWith;
        $this->level_4_points_to_give =
            $this->default_level_4_points_to_give * $valueToBeDivideWith;
        $this->level_5_points_to_give =
            $this->default_level_5_points_to_give * $valueToBeDivideWith;
        $this->standard_kudos_value =
            $this->default_standard_kudos_value * $valueToBeDivideWith;
        $this->super_kudos_value =
            $this->default_super_kudos_value * $valueToBeDivideWith;
        $this->birthday_kudos_value =
            $this->default_birthday_kudos_value * $valueToBeDivideWith;
        $this->anniversary_kudos_value =
            $this->default_anniversary_kudos_value * $valueToBeDivideWith;
        $this->default_kudos_amount =
            $this->default_kudos_amount_value * $valueToBeDivideWith;
    }
}
