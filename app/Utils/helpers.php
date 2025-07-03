<?php

use App\Models\ConversionRate;
use Carbon\Carbon;

function get_initials($name, $chars = null)
{
    $initials = '';
    $name = name_without_prefix($name);

    $nameParts = explode(' ', preg_replace("/\s+/", ' ', $name));

    if (count($nameParts) < 2) {
        return $name[0];
    }

    for ($i = 0, $iMax = count($nameParts); $i < $iMax; $i++) {
        if ($chars && $i >= $chars) {
            break;
        }

        $initials .= $nameParts[$i][0];
    }

    return strtoupper($initials);
}

function name_without_prefix($name)
{
    $prefix = [
        'mr ',
        'mr. ',
        'ms ',
        'ms. ',
        'mrs ',
        'mrs. ',
        'dr ',
        'dr. ',
        'st ',
        'st. ',
    ];

    foreach ($prefix as &$item) {
        $item = "/^$item/";
    }

    return preg_replace($prefix, '', strtolower($name));
}

function giverName($point)
{
    return data_get($point, 'giver.name', config('app.name'));
}

function showSpecialKudosOptions($point, $userId = null): bool
{
    $userId = $userId ?? auth()->id();

    return $point->user_id == $userId || $point->from_id == $userId;
}

function showStandardKudosOptions($point, $userId = null): bool
{
    $userId = $userId ?? auth()->id();

    return ($point->user_id == $userId || $point->from_id == $userId) &&
        ! (
            $point->hidden &&
            $point->hidden_by &&
            ($point->hidden_by != $userId &&
                \App\Models\User::where('id', $point->hidden_by)
                    ->where('developer', 1)
                    ->exists())
        );
}

function defaultDateFormat($date)
{
    if (! $date) {
        return 'N/A';
    }

    return Carbon::parse($date)->format('g:ia \o\n M jS, Y');
}

function getReplacedWordOfKudos($default = false, $user = null)
{
    if ($default) {
        return 'Kudos';
    }

    $user = $user ?? auth()->user();
    $companyId = data_get($user, 'company.id');

    return Cache::remember(
        'customized_name_of_kudos_'.$companyId,
        43200,
        function () use ($user) {
            if ($user && $user->company) {
                return $user->company->customized_name_of_kudos ?? 'Kudos';
            }

            return 'Kudos';
        }
    );
}

function whitelabel_company($user = null)
{
    $whitelabelCompany = data_get(
        $user ?? auth()->user(),
        'company.whitelabel_company'
    );

    return $whitelabelCompany && $whitelabelCompany->whitelabel_enabled
        ? $whitelabelCompany
        : null;
}

function appFavicon($default = false, $user = null)
{
    if ($default) {
        return url('/other/perksweet-favicon.png');
    }

    return data_get(
        whitelabel_company($user),
        'logo_path',
        url('/other/perksweet-favicon.png')
    );
}

function appLogo($default = false, $user = null)
{
    if ($default) {
        return url('/other/perksweet.png');
    }

    return data_get(whitelabel_company($user), 'logo_path') ?? url('/other/perksweet.png');
}

function appName($default = false, $user = null)
{
    if ($default) {
        return config('app.name') ?? 'PerkSweet';
    }

    return data_get(whitelabel_company($user), 'name', config('app.name')) ?? 'PerkSweet';
}

function getCustomizeNumberOfKudos()
{
    return optional(auth()->user()->company)->customized_number_of_kudos;
}

function currencyNumber($amount, $currency)
{
    if (! $currency) {
        $currency = 'USD';
    }

    switch ($currency) {
        case 'USD':
            return '$'.number_format(round($amount, 2), 2);
        case 'EUR':
            return '€'.number_format(round($amount, 2), 2);
        case 'GBP':
            return '£'.number_format(round($amount, 2), 2);
        case 'CAD':
            return 'C$'.number_format(round($amount, 2), 2);
        case 'JPY':
            return '¥'.number_format(round($amount, 2), 2);
        case 'AUD':
            return 'A$'.number_format(round($amount, 2), 2);
        case 'BRL':
            return 'R$'.number_format(round($amount, 2), 2);
        case 'MXN':
            return 'Mex$'.number_format(round($amount, 2), 2);
        case 'PHP':
            return '₱'.number_format(round($amount, 2), 2);
        case 'PLN':
            return number_format(round($amount, 2), 2).' zł';
        case 'SEK':
            return number_format(round($amount, 2), 2).' kr';
        case 'SGD':
            return 'S$'.number_format(round($amount, 2), 2);
    }

    return number_format(round($amount, 2), 2).' '.$currency;
}

function getCurrencyRate($currency = 'USD')
{
    if ($currency == 'USD') {
        $conversionRate = 1;
    } else {
        if (
            $conversionRate = ConversionRate::reward($currency)
                ->base('USD')
                ->first()
        ) {
            $conversionRate = $conversionRate->base_fx;
        }
    }

    return $conversionRate;
}

function convertKudos($amount, $currency = 'USD')
{
    return ($amount / getCustomizeNumberOfKudos()) * getCurrencyRate($currency);
}
