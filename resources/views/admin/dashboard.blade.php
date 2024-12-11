@extends('admin.layouts.master')

@section('page')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <!-- Total Visitors -->
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="icon-big icon-warning text-center">
                                <i class="ti-eye"></i>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="numbers">
                                <p>Total Visitors</p>
                                11022
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr/>
                        <div class="stats">
                            <i class="ti-panel"></i> Details
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products -->
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="icon-big icon-success text-center">
                                <i class="ti-archive"></i>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="numbers">
                                <p>Products</p>
                                {{ $product->count() }}
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr/>
                        <div class="stats">
                            <a href="{{ url('/products') }}"><i class="ti-panel"></i> Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders -->
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="icon-big icon-danger text-center">
                                <i class="ti-shopping-cart-full"></i>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="numbers">
                                <p>Orders</p>
                                {{ $order->count() }}
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr/>
                        <div class="stats">
                            <a href="{{ url('/orders') }}"><i class="ti-panel"></i> Orders</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users -->
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="icon-big icon-info text-center">
                                <i class="ti-user"></i>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="numbers">
                                <p>Users</p>
                                {{ $user->count() }}
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr/>
                        <div class="stats">
                            <a href="{{ url('/users') }}"><i class="ti-panel"></i> Users</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteneur du graphique -->
    <div id="salesData" style="margin-top: 30px;">
        <!-- Canvas pour afficher le graphique -->
        <canvas id="salesChart" width="400" height="200"></canvas>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            // Requête AJAX pour obtenir les données de ventes
            $.ajax({
                url: '{{ route("dashboard.sales") }}',
                method: 'GET',
                success: function(response) {
                    // Traiter la réponse pour afficher le graphique
                    let labels = [];
                    let data = [];

                    // Parcourir les résultats pour obtenir les produits et les ventes
                    response.forEach(function(item) {
                        // Récupérer les labels (produits) et les données (quantités)
                        labels.push(item.product_id);  // À adapter selon la façon dont vous récupérez le nom du produit
                        data.push(item.total_sales);
                    });

                    // Utiliser une bibliothèque de graphiques (comme Chart.js) pour afficher les données
                    var ctx = document.getElementById('salesChart').getContext('2d');
                    var salesChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Quantité Vendue',
            data: data,
            backgroundColor: 'rgba(242, 176, 77, 1)',
            borderColor: 'rgba(255, 165, 0, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: false, // Désactive le mode responsive pour un contrôle précis
        plugins: {
            legend: {
                display: false // Facultatif : pour cacher la légende
            }
        },
        scales: {
            x: {
                barThickness: 75.59, // Largeur fixe en pixels (~2 cm)
                categoryPercentage: 0.5, // Réduit la largeur de chaque catégorie pour créer de l'espace
                ticks: {
                    padding: 20 // Facultatif : ajoute de l'espace supplémentaire autour des labels
                }
            },
            y: {
                beginAtZero: true
            }
        }
    }
});

                },
                error: function(xhr, status, error) {
                    alert('Erreur lors de la récupération des données.');
                }
            });
        });
    </script>
@endsection
