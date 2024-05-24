<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="circuit.css">
    <link rel="shortcut icon" type="image" href="./public/logo.jpg" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Bello Sguardo - circuit</title>
</head>
<body>
    <?php
    require("header.php");
    ?>
    <main>
        <h1>CIRCUITO PRINCIPALE</h1>
        <section class="heroSection_principal"></section>
        <section class="desciption_principal">
            <p>
                In questa pagina descriviamo esaustivamente tutto ciò che compone <strong>BelloSguardo</strong> a livello circuitale.<br>
                BelloSguardo è un sistema di rilevamento integrato in un simpatico mimit , interamente creato da zero , dal nostro team , in tutte le sue parti, presentato come progetto della scuola <strong>ISIT Bassi-Burgatti (Cento, FE)</strong> alla competizione <strong>SchoolMakerDay</strong> di Sabato 25 Maggio 2024<br>
                BelloSguardo implementa <strong>due modalità</strong> di controllo principali: 
                <ul>
                    <li><strong>Auto Mode</strong></li>
                    <li><strong>Manual Mode</strong></li>
                </ul>
                La modalità automatica consente , attraverso una telecamera , una sofisticato <strong>riconoscimento facciale</strong> dei soggetti attraverso AI, con relativa funzione <strong>"Follow me"</strong>.
                La modalità manuale, al contrario, disattiva temporaneamente la telecamera , a favore di un pieno controllo manuale attraverso:
                <ul>
                    <li><strong>Controller Wireless</strong></li>
                    <li><strong><a href="#telegram-bot" style="color: black;">Telegram Bot</a> (clicca per ulteriori informazioni a riguardo)</strong></li>
                    <li><strong>Google Fogli</strong></li>
                </ul>
                Di seguito elencati tutti i componenti utilizzati per la realizzazione del progetto:
                <ul>
                    <li><strong>4 ESP32</strong></li>
                    <li><strong>2 ESP32-Cam con relativa camera OV2640(120° 75mm)</strong></li>
                    <li><strong>6 Servomotori 180°</strong></li>
                    <li><strong>Batteria 18650 5V 5000mAh</strong></li>
                    <li><strong>Batteria 9V</strong></li>
                    <li><strong>Potenziometro</strong></li>
                    <li><strong>Joystick</strong></li>
                    <li><strong>LED Vari</strong></li>
                    <li><strong><a href="#3dModels" style="color: black;">Stampe 3D</a> (clicca per ulteriori informazioni a riguardo)</strong></li>
                    <li><strong>Viti e bulloni M2/M3</strong></li>
                </ul>
                Vediamo adesso nel dettaglio tutte le principali parti che compongono Bellosguardo
            </p>
        </section>
        <section class="circuit_focus">
            <article class="cams">
                <div class="cam_focus_image"></div>
                <div class="description">
                    Bellosguardo è dotato di 2 telecamere modello OV2640 con un campo visivo di 120°, ognuna delle quali integrata in un ESP32.
                    La prima ESP-Cam , attraverso apposito sketch , hosta un WebServer in rete , condividendo lo streaming della telecamera in tempo reale, uno script python
                    in esecuzione su un computer esterno(in quanto un ESP non ha abbastanza potenza computazionale), si occupa poi di recuperare i frame relativi allo streaming e processarli, 
                    rilevando i volti fino ad una distanza di 3m , attraverso la libreria OpenCv. Le coordinate dei volti vengono poi reinviate alla ESP-Cam attraverso porta seriale.

                    La seconda telecamera , invece, si occupa solamente di scattare immagini dell'attuale campo visivo, quando richiesto dal Telegram Bot (2 camere da 120° sarebbero state ridondanti)
                </div>
            </article>

            <article class="controller-slave">
                <div class="controllerSlave_focus_image"></div>
                <div class="description">
                    L'ESP32 Controller Slave in comunicazione con il controller wireless funge da ricevitore dei movimenti impartiti da questo. Attraverso il protocollo ESP-NOW(Ideato da Espressif), i due ESP32 in comunicazione(uno nel controller e un altro nel progetto principale) comunicano tra di loro in un modello Master/Slave     
                    <br>
                    <a href="#Controller-circuit" style="color: white;">Scopri di più</a>
                </div>
            </article>
            <article class="webServer">
                <div class="webServer_focus_image"></div>
                <div class="description">L'ESP32 in figura, hosta un WebServer atto a gestire l'inserimento delle coordinate di BelloSguardo direttamente da un Google Fogli appositamente creato. Il WebServer, esclusivamente in modalità manuale, manda una richiesta GET ad un Google AppScript , il quale interroga il foglio google e restituisce i valori delle coordinate i quali, se diversi dai precedenti, vengono inviati al ServoHandler. L'inserimento dei valori nel foglio google può avvenire anche attraverso il Telegram Bot</div>
            </article>
            <article class="servo-handler">
                <div class="servoHandler_focus_image"></div>
                <div class="description">
                   Come abbiamo già detto, L'ESP Servo Handler è responsabile del movimento dei servomotori. Di questi ne sono presenti 6 , in coppia , ciascuno incaricato di un particolare movimento:
                   <ul>
                        <li><strong>la prima coppia di servomotori SM-X e SM-Y muovono gli occhi nelle 4 direzioni.</strong></li>
                        <li><strong>Altri 2 coppie, una per lato SM-RIGHT1 SM-RIGHT2 e SM-LEFT1 SM-LEFT2, aprono e chiudono le sopracciglia</strong></li>
                   </ul>
                </div>
            </article>
            <article class="serial-attachment">
                <div class="serialAttachment_focus_image"></div>
                <div class="description">Tutti gli ESP visti fino ad ora, elaborano i dati e li inviano all'ESP Servo Handler, il cui unico compito è quello di muovere i servomotori. La comunicazione è di tipo seriale ed è dotata di un meccanismo a priorità gestita via software per evitare la sovrapposizione di coordinate</div>
            </article>
        </section>

        <a name="Controller-circuit">
            <h1 style="margin-top: 100px; margin-bottom: 50px">CIRCUITO DEL CONTROLLER</h1>
        </a>
        <section class="heroSection_controller"></section>
        <div class="controller-desrciption">
            <p>
                Come già abbiamo anticipato, il principale metodo di controllo per BelloSguardo, esclusivamente in modalità manuale, è costituito dal Controller Wireless(Vedi circuito sopra). Il controller è composto da diversi componenti principali, tutti saldati assieme in un solido circuito su pcb millefori:
                <ul>
                    <li><strong>Joystick</strong>, per il comando remoto dei 2 servomotori: SM-X e SM-Y</li>
                    <li><strong>Potenziometro</strong>, per il comando remoto dei 4 servomotori: SM-RIGHT1, SM-RIGHT2, SM-LEFT1 e  SM-LEFT2</li>
                    <li><strong>LED di stato</strong></li>
                    <li><strong>ESP32(master)</strong></li>
                    <li><strong>Switch On/Off</strong></li>
                    <li><strong>Batteria 9V</strong></li>
                </ul>
                Come già detto, l'ESP32 master, comunica con lo salve presente in BelloSguardo tramite protocollo ESP-Now, inviando i dati rilevati da joystick e potenziometro.
                Dopo aver acceso il controller attraverso l'apposito switch On/Off, il LED di stato inizierà a lampeggiare per poi diventare fisso una volta che il collegamento con lo slave è stato ultimato, e la trasmissione dati può quindi iniziare  
            </p>
        </div>
        <a name="telegram-bot">
            <h1>FUNZIONAMENTO DEL TELEGRAM BOT</h1>
        </a>
        <section class="heroSection_telegramBot"></section>
        <section class="bot_description">
            <aside class="tg_bot_image1"></aside>
            <article class="textual_description">
                <p>
                    Un ultreriore modo di controllare Bellosguardo è dato dal Telegram Bot (<a href="https://t.me/Bello_Sguardo_bot" style="color: black;">clicca per provare il telegram bot per BelloSguardo</a>), attraverso il quale è possibile, esclusivamente in modalità manuale:
                    <ul>
                        <li><strong>Visualizzare gli attuali valori impostati</strong></li>
                        <li><strong>Scattare immagini in tempo reale dalla camera</strong></li>
                        <li><strong>Impostare nuovi valori</strong></li>
                    </ul>
                    L'impostazione di nuovi valori avviene attraverso una richiesta POST ad un Google AppScript il quale interagisce direttamente con il foglio Google interessato(lo stesso dal quale l'ESP WebServer for Excel prende i dati) contenente i valori. 
                </p>
            </article>
            <aside class="tg_bot_image2"></aside>
        </section>
        <a name="3dModels">
            <h1>MODELLI 3D</h1>
        </a>
        <section class="my-carousel">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                    </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="./public/base.png" alt="First slide">
                        <div class="carousel-caption d-md-block background">
                            <h5>Base</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="./public/ServoSupport.png" alt="First slide">
                        <div class="carousel-caption d-md-block background w-70">
                            <h5>Supporto servo-motori</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="./public/EyeLids.png" alt="Second slide">
                        <div class="carousel-caption d-md-block background">
                            <h5>Palpebre superiori ed inferiori</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="./public/Eyes.png" alt="Third slide">
                        <div class="carousel-caption d-md-block background">
                            <h5>Bulbo oculare e supporto</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="./public/Links.png" alt="Fourth slide">
                        <div class="carousel-caption d-md-block background">
                            <h5>Collegamenti per movimenti</h5>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </section>
    </main>
    <?php
    require("footer.php");
    ?>
</body>
</html>