<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\ContasPagar;
use App\Models\ContasReceber;
use App\Models\CustoVeiculo;
use App\Models\FluxoCaixa;
use App\Models\Fornecedor;
use App\Models\Locacao;
use App\Models\Marca;
use App\Models\Veiculo;
use App\Policies\AgendamentoPolicy;
use App\Policies\ClientePolicy;
use App\Policies\ContasPagarPolicy;
use App\Policies\ContasReceberPolicy;
use App\Policies\CustoVeiculoPolicy;
use App\Policies\FluxoCaixaPolicy;
use App\Policies\FornecedorPolicy;
use App\Policies\LocacaoPolicy;
use App\Policies\MarcaPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Policies\VeiculoPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Agendamento::class => AgendamentoPolicy::class,
        Cliente::class => ClientePolicy::class,
        ContasPagar::class => ContasPagarPolicy::class,
        ContasReceber::class => ContasReceberPolicy::class,
        CustoVeiculo::class => CustoVeiculoPolicy::class,
        Fornecedor::class => FornecedorPolicy::class,
        Locacao::class => LocacaoPolicy::class,
        Marca::class => MarcaPolicy::class,
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
        Veiculo::class => VeiculoPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
