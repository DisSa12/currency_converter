<?php
// Funzione per recuperare i tassi di cambio da un'API esterna
function fetchExchangeRates() {
    $apiKey = 'f06da45a626aaa39467a819e'; // API key fornita dal provider
    $url = "https://v6.exchangerate-api.com/v6/{$apiKey}/latest/USD"; // URL dell'API a cui fare la richiesta
    $response = file_get_contents($url); // Richiesta dei dati all'API
    $data = json_decode($response, true); // Decodifica dei dati JSON in un array PHP
    return $data['conversion_rates']; // Restituzione dell'array di tassi di cambio
}

$exchangeRates = fetchExchangeRates(); // Chiamata alla funzione per recuperare i tassi di cambio

// Definizione della classe "CurrencyConverter"
class CurrencyConverter {
    private $exchangeRates; // Proprietà privata che contiene i tassi di cambio

    // Costruttore della classe
    public function __construct($exchangeRates) {
        $this->exchangeRates = $exchangeRates; // Inizializzazione della proprietà con i tassi di cambio forniti
    }

    // Metodo per la conversione della valuta
    public function convertCurrency($params) {
        $amount = $params->amount; // Importo da convertire
        $fromCurrency = $params->fromCurrency; // Valuta di partenza
        $toCurrency = $params->toCurrency; // Valuta di destinazione

        if (isset($this->exchangeRates[$fromCurrency]) && isset($this->exchangeRates[$toCurrency])) {
            $fromRate = floatval($this->exchangeRates[$fromCurrency]); // Tasso di cambio della valuta di partenza
            $toRate = floatval($this->exchangeRates[$toCurrency]); // Tasso di cambio della valuta di destinazione
            $result = $amount * ($toRate / $fromRate); // Calcolo dell'importo convertito
            return ['result' => $result]; // Restituzione del valore dell'importo convertito
        } else {
            throw new Exception("Valuta non supportata: $fromCurrency o $toCurrency"); // Lancio di un'eccezione nel caso in cui le valute non siano supportate
        }
    }
}

$server = new SoapServer("http://localhost/currency_converter/currency_converter.wsdl"); // Creazione del server SOAP
$server->setObject(new CurrencyConverter($exchangeRates)); // Impostazione dell'oggetto gestito con la classe "CurrencyConverter"
$server->handle(); // Gestione delle richieste SOAP.
?>