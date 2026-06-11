<?php

declare(strict_types=1);

use App\Enums\Niveau;
use App\Imports\UsersImport;

test('gce a level is defined in Niveau enum', function (): void {
    expect(Niveau::GCE_A_LEVEL->value)->toBe('gce_a_level');
    expect(Niveau::GCE_A_LEVEL->label())->toBe('GCE ADVANCED A LEVEL');
    expect(Niveau::GCE_A_LEVEL->description())->toBe('GCE Advanced A Level');
    expect(Niveau::grouped()['Secondaire (2nd cycle)']['gce_a_level'])->toBe('GCE ADVANCED A LEVEL');
});

test('UsersImport maps gce a level strings correctly', function (): void {
    $import = new UsersImport;
    $reflection = new ReflectionClass(UsersImport::class);
    $method = $reflection->getMethod('getNiveauEnum');
    $method->setAccessible(true);

    expect($method->invoke($import, 'GCE ADVANCED A LEVEL'))->toBe(Niveau::GCE_A_LEVEL);
    expect($method->invoke($import, 'gce advanced level'))->toBe(Niveau::GCE_A_LEVEL);
    expect($method->invoke($import, 'gce a-level'))->toBe(Niveau::GCE_A_LEVEL);
    expect($method->invoke($import, 'A-Level'))->toBe(Niveau::GCE_A_LEVEL);
});
