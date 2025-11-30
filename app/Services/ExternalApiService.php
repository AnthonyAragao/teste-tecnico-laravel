<?php

namespace App\Services;

use App\Contracts\ExternalApiServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ExternalApiService implements ExternalApiServiceInterface
{
    public function generateAvatar(): string
    {
        try {
            $response = Http::get('https://app.pixelencounter.com/api/basic/monsters/random');
            
            if ($response->successful()) {
                $imageUrl = $response->json('url');
                $imageResponse = Http::get($imageUrl);
                
                if ($imageResponse->successful()) {
                    return 'data:image/png;base64,' . base64_encode($imageResponse->body());
                }
            }
        } catch (\Exception $e) {
            // Fallback: gerar avatar simples
        }
        
        return $this->generateFallbackAvatar();
    }

    public function getCountries(): array
    {
        return Cache::remember('countries', 3600, function () {
            try {
                $response = Http::get('https://restcountries.com/v3.1/all?fields=name,idd');
                
                if ($response->successful()) {
                    $countries = collect($response->json())
                        ->filter(fn($country) => isset($country['idd']['root']) && isset($country['idd']['suffixes']))
                        ->map(function ($country) {
                            $callingCode = $country['idd']['root'] . ($country['idd']['suffixes'][0] ?? '');
                            return [
                                'name' => $country['name']['common'],
                                'calling_code' => str_replace('+', '', $callingCode)
                            ];
                        })
                        ->sortBy('name')
                        ->values()
                        ->toArray();
                    
                    return $countries;
                }
            } catch (\Exception $e) {
                // Log error
            }
            
            return $this->getFallbackCountries();
        });
    }

    private function generateFallbackAvatar(): string
    {
        // Gerar um avatar SVG simples
        $colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7'];
        $color = $colors[array_rand($colors)];
        
        $svg = '<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="50" fill="' . $color . '"/>
                    <circle cx="35" cy="40" r="5" fill="white"/>
                    <circle cx="65" cy="40" r="5" fill="white"/>
                    <path d="M 30 70 Q 50 85 70 70" stroke="white" stroke-width="3" fill="none"/>
                </svg>';
        
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    private function getFallbackCountries(): array
    {
        return [
            ['name' => 'Brazil', 'calling_code' => '55'],
            ['name' => 'United States', 'calling_code' => '1'],
            ['name' => 'Portugal', 'calling_code' => '351'],
            ['name' => 'Spain', 'calling_code' => '34'],
            ['name' => 'France', 'calling_code' => '33'],
        ];
    }
}