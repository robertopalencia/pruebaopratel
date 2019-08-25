<?php

namespace App\Console\Commands;

use App\Mail\Usuarios;
use App\Payment;
use Jenssegers\Mongodb\Auth\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class GetUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia un correo con el numero de usuarios sin cobro del dia en curso';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $todaypayments = Payment::with('users')->where('create_at',  Carbon::now());
        $totalusers = User::all();
        $total = count($totalusers)-count($todaypayments);

        Mail::to('rpalencia.produccion@gmail.com')->send(new Usuarios($total));
    }
}
