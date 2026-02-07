'role' => \App\Http\Middleware\RoleMiddleware::class,
'company.profile' => \App\Http\Middleware\EnsureCompanyProfileComplete::class,
'admin' => \App\Http\Middleware\EnsureAdmin::class,
