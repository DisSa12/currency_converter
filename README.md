# CurrencyConverter

Il servizio di conversione di valuta è un'applicazione web basata su SOAP che fornisce un'interfaccia per convertire importi tra diverse valute. L'applicazione utilizza il protocollo SOAP per gestire le richieste e le risposte tra il client e il server.

## Struttura del progetto

Il progetto è composto dai seguenti file principali:

- `server.php`: il server SOAP che implementa il servizio di conversione di valuta.
- `client.php`: un esempio di client SOAP che interagisce con il servizio di conversione di valuta.
- `CurrencyConverter.wsdl`: il file WSDL che descrive l'interfaccia del servizio di conversione di valuta.
- `README.md`: questo file, che fornisce informazioni sul progetto e le istruzioni per l'uso.

## Istruzioni per l'uso

1. Assicurarsi di avere un server web (come Apache o Nginx) con il supporto per PHP abilitato.
2. Copiare tutti i file del progetto nella directory del server web.
3. Avviare il server web.
4. Aprire un browser e visitare l'URL del client (ad esempio, `http://localhost/currency_converter/client.php`) per testare il servizio di conversione di valuta.

## Funzionamento del servizio

Il servizio di conversione di valuta fornisce un'operazione chiamata `convertCurrency`. Questa operazione accetta come input due valute (ad esempio, "USD" e "EUR") e un importo da convertire. Il servizio restituisce l'importo convertito nell'altra valuta, utilizzando un tasso di cambio predefinito o recuperato da un servizio esterno.

Ecco un esempio di input e output per l'operazione `convertCurrency`:

- Input: `convertCurrency("USD", "EUR", 100)`
- Output: `85.00` (considerando un tasso di cambio di 1 USD = 0,85 EUR)

## Note sulla sicurezza e le prestazioni

Il servizio di conversione di valuta è un esempio di base e non include funzionalità avanzate come l'autenticazione, la gestione degli errori o la memorizzazione nella cache dei tassi di cambio. Per migliorare la sicurezza e le prestazioni, si consiglia di implementare queste funzionalità prima di utilizzare il servizio in un ambiente di produzione.
