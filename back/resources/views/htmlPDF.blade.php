<!DOCTYPE html>
<html>
<head>
    <title>Laravel HTML to PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
        {{--<img src="{{ public_path("/image/logo.jpg")}}" class="img-fluid" style="height: 140px;width: 170px" alt="logo">--}}


        <img src="{{ public_path("/image/logo.jpg")}}" class="img-fluid" style="height: 140px;width: 170px" alt="logo">
        <div class="float-right">
            <h3>
                GEOMAPING SARL
            </h3>
            <p style="font-size: 10px">Imm 97, Appt 4 et 5, Avenue Omar Ben Elkhattab,<br>

                Elyoussoufia.<br>
                85000 TIZNIT<br>
                Tél : 0528-601878 / 0666-599001<br>
                Email : geomaping.sarl@gmail.com<br>
                ICE : 000010420000057<br>
            </p>
            <div style="height: 100px;width: 170px;background-color: #e2f2fd">
                <h6>
                    CLIENT :
                </h6>
                {{$data['client_n']}}
                ICE :{{$data['client_ice']}}
            </div>
        </div>

            <div style="height: 140px;width: 170px;background-color: #e2f2fd">
                <h6>
                    Devis N°:{{$data['devis_n']}}
                </h6>
                Date de création :{{$data['devis_date_c']}} <br>
                Date d'échéance :{{$data['devis_date_e']}} <br>
            </div>

            <p>Objet :Etablissement {{$data['Etablissement']}}</p>
        <br>

        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Désignation</th>
                <th scope="col">Unité</th>
                <th scope="col">Quantité</th>
                <th scope="col">Prix unitaire HT</th>
                <th scope="col">Prix Total HT</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data['tableDetails'] as $key => $value)
                    <tr>
                        <td>{{$value['Ds']}}</td>
                        <td>{{$value['Un']}}</td>
                        <td>{{$value['qt']}}</td>
                        <td>{{$value['pu']}}</td>
                        <td>{{$value['pt']}}</td>
                    </tr>
            @endforeach
            </tbody>
        </table>
        <br>

        <div class="float-right" style="height: 100px;width: 170px;background-color: #e2f2fd">
            <div class="d-flex justify-content-center">Montant HT<br></div>
            <div class="d-flex justify-content-center">Total TVA 20%<br></div>
            <div style="height: 40px;width: 170px;background-color: #21a8f4">
                <h6>
                    Total TTC
                </h6>
            </div>
        </div>
        <br>
        <div  style="height: 100px;width: 170px">
            <br>
            <br>
            <br>
            <br>

        </div><br>
        <div>
           <p>
               Ce présent …………… EST ARRETEE A LA SOMME : ……….. TTC (En lettres)<br>
           </p>
            <h4>Ref: (référence généré par l’application pour les {{$data['type']}})</h4>
            <h4 class="float-right">Signature</h4>
        </div>
<br>
<br>
<div style="background-color: #2195f2;font-size: 8px;color: white;height: 130px;width: 100%">
    <p style=" margin: auto;
  width: 50%;
  padding: 10px;">
        Adresse imm 97, Appt 4 et 5, Avenue Omar Ben Elkhattab, Tiznit, 85000<br>
        R.C:24 25, IF:14492962, COMPTE BMCE : 011750 <br>

        000003210000207572, Site web : …………………………………..<br>
        I.CE : 000010420000057, Email : geomaping.sarl@gmail.com

    </p>

</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
</body>
</html>
