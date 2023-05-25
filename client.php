<?php
// Decodifica del file JSON contenente le valute e loro simboli
$currencies = json_decode(file_get_contents("currencies.json"));
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Convertitore di valuta</title>
    <!-- Carica il foglio di stile di Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Carica il foglio di stile di Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        // Stili CSS personalizzati per il layout e l'aspetto dell'applicazione
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            max-width: 600px;
            flex: 1;
            margin-top: 5%;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px 0 rgba(0,0,0,0.1);
            padding: 20px;
        }

        h1 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #007bff;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }

        footer p {
            margin-bottom: 0;
            font-size: 14px;
            color: #6c757d;
        }

        .btn-convert {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn-convert-text {
            margin: 0 auto;
        }
        .risultato {
            font-weight: bold;
            font-size: 24px;
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            border-radius: 5px;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.25);
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Titolo dell'applicazione -->
        <h1 class="my-4">Convertitore di valuta</h1>
        <!-- Form per inserire l'importo e selezionare le valute -->
        <form action="client.php" method="post" class="needs-validation" novalidate>
            <!-- Campo per l'importo -->
            <div class="form-group">
                <label for="amount">Importo:</label>
                <input type="number" name="amount" step="0.01" required class="form-control" id="amount">
                <div class="invalid-feedback">Inserisci un importo valido.</div>
            </div>
            <!-- Campo per la valuta di partenza -->
            <div class="form-group">
                <label for="fromCurrency">Valuta di partenza:</label>
                <!-- Creazione del menu a discesa per selezionare la valuta di partenza -->
                <select name="fromCurrency" required class="form-control select2" id="fromCurrency">
                    <?php // Utilizza un ciclo foreach per generare dinamicamente le opzioni del menu a discesa con le valute disponibili
                    foreach ($currencies as $currency): ?>
                        <option value="<?php echo $currency->code; ?>"><?php echo $currency->name; ?> (<?php echo $currency->code; ?>)</option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Seleziona una valuta di partenza.</div>
            </div>
            <!-- Campo per la valuta di destinazione -->
            <div class="form-group">
                <label for="toCurrency">Valuta di destinazione:</label>
                <!-- Creazione del menu a discesa per selezionare la valuta di arrivo -->
                <select name="toCurrency" required class="form-control select2" id="toCurrency">
                    <?php // Utilizza un ciclo foreach per generare dinamicamente le opzioni del menu a discesa con le valute disponibili
                    foreach ($currencies as $currency): ?>
                        <option value="<?php echo $currency->code; ?>"><?php echo $currency->name; ?> (<?php echo $currency->code; ?>)</option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Seleziona una valuta di destinazione.</div>
            </div>
            <!-- Bottone per avviare la conversione -->
            <button type="submit" class="btn btn-primary btn-convert">
                <span class="btn-convert-text">Converti</span>
            </button>
        </form>
        <!-- Logica PHP per effettuare la conversione utilizzando il servizio SOAP -->
        <?php
            // Controlla se il metodo della richiesta è POST
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Ottieni l'importo, la valuta di partenza e la valuta di destinazione dall'input dell'utente
                $amount = floatval($_POST['amount']);
                $fromCurrency = $_POST['fromCurrency'];
                $toCurrency = $_POST['toCurrency'];

                // Imposta l'URL del WSDL del servizio SOAP del convertitore di valuta
                $wsdl = "http://localhost/currency_converter/currency_converter.wsdl";
                // Crea un nuovo client SOAP utilizzando l'URL del WSDL
                $client = new SoapClient($wsdl);

                // Prova a chiamare il metodo `convertCurrency` del servizio SOAP
                try {
                    // Esegui la conversione di valuta e ottieni il risultato
                    $result = $client->convertCurrency([
                        'amount' => $amount,
                        'fromCurrency' => $fromCurrency,
                        'toCurrency' => $toCurrency
                    ]);
                    // Visualizza il risultato della conversione su schermo
                    echo "<p class='risultato mt-5'>Risultato: {$amount} {$fromCurrency} = {$result->result} {$toCurrency}</p>";
                } catch (Exception $e) {
                    // Cattura e visualizza l'errore su schermo, se si verifica un'eccezione
                    echo '<p class="mt-5 text-danger">Errore: ' . htmlentities($e->getMessage()) . '</p>';
                }
            }
        ?>
    </div>

    <!-- Footer dell'applicazione -->
    <footer>
        <p>Realizzato da Matteo Di Salvo</p>
    </footer>

    <!-- Inclusione delle librerie JavaScript -->

    <!-- 1. jQuery: libreria per manipolazione DOM, gestione eventi e AJAX -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- 2. Bootstrap: framework per componenti CSS e JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- 3. Popper.js: libreria per posizionamento dinamico di elementi -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>

    <!-- 4. Select2: plugin per migliorare usabilità e funzionalità dei menu a discesa -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <!-- Codice JavaScript personalizzato -->
    <script>
        $(document).ready(function() {
            // Inizializza il plugin Select2 sui campi di selezione delle valute
            $('.select2').select2();

            // Aggiunge la validazione del modulo al momento della presentazione
            $('.needs-validation').on('submit', function(e) {
                // Se la validità del modulo è falsa, previene l'invio e la propagazione dell'evento
                if (this.checkValidity() === false) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                // Aggiunge la classe 'was-validated' al modulo per mostrare gli stati di validazione
                this.classList.add('was-validated');
            });
        });
    </script>
</body>
</html>