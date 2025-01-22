<h1>Nouvelle Commande</h1>
<h3>Bonjour Senkomkom, {{ $user }}.</h3>
<p>{{$Content}}</p>
<style>
    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }

    thead  th {
        background-color: darkgray;
    }

    tfoot  th {
        background-color: darkgray;
    }

    th,
    td {
        text-align: left;
        padding: 16px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>
            <div class="tbl-header">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Article Nom</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                        </tr>
                    </thead>
                    <tbody class="tbl-content">
                        @php
                        $montant =0;
                        @endphp
                        @foreach($Cmd_articles as $k => $article)
                        @php
                        $item = Helper::getTableRecordWithId("articles", $article)[0];
                        $montant = $montant += $item->prix*$qty_articles[$k];
                        @endphp
                        <tr>
                            <td class="align-middle">{{$item->nom}}</td>
                            <td class="align-middle">{{$item->prix}} FCFA</td>
                            <td class="align-middle">{{$qty_articles[$k]}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                          <th >Total (avec livraison)</th>
                          <th  colspan="2" id='total'>{{$montant+$livraison}} FCFA</th>
                      </tr>
                   </tfoot>
                </table>
            </div>
    
<p>Senkomkom, votre boutique en ligne!!!</p>    