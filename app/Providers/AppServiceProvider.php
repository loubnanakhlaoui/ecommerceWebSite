<?php  
namespace App\Providers;  

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade; // N'oubliez pas d'ajouter cette ligne d'import

class AppServiceProvider extends ServiceProvider {      
    public function boot()     {         
        Schema::defaultStringLength(191);
        
        Blade::directive('json', function ($expression) {
            return "<?php echo json_encode($expression); ?>";
        });
    }      

    /**      
     * Register any application services.      
     *      
     * @return void      
     */     
    public function register()     {         
        //     
    } 
}