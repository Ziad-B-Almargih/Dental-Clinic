<?php

namespace App\Services;

use App\Jobs\SendForgetPasswordCodeJob;
use App\Models\ResetPassword;

class ResetPasswordServices
{
    public function create(string $email): void {
        $this->delete($email);

        $code = $this->generateCode();
        ResetPassword::query()
            ->create([
                'email' => $email,
                'code'  => $code
            ]);

        SendForgetPasswordCodeJob::dispatch($email, $code);
    }

    public function delete(string $email): void {
        ResetPassword::query()
            ->firstWhere('email', $email)
            ?->delete();
    }

    private function generateCode(): int{
        return rand(100000, 999999);
    }

    public function check(string $email, int $code): bool
    {
        $reset = ResetPassword::query()
            ->firstWhere('email', $email);

        return ( $reset && $reset['code'] == $code );
    }
}
