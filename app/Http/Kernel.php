protected $middlewareAliases = [
    // ... alias เดิม ๆ ของคุณ
    'auth'  => \App\Http\Middleware\Authenticate::class,
    // ...
    'admin' => \App\Http\Middleware\AdminMiddleware::class, // << เพิ่มบรรทัดนี้
];
