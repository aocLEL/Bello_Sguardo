<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="description_image.css">
    <link rel="shortcut icon" type="image" href="./public/logo.jpg" />
    <title>Bello Sguardo - IMAGE</title>
</head>
<body>
    <?php
        require("header.php");
    ?>
    <main>
        <h1>GALLERIA IMMAGINI BELLO SGUARDO</h1>
        <section style="display: flex; justify-content: center; align-items: center;">
            <div class="gallery">
                <div class="gallery-item">
                    <img src="./public/image_1.jpg" alt="Saldatura completa del controller, con anche regolatore di tensione inserito nel circuito con appositi condensatori" class="image">
                </div>
                <div class="gallery-item">
                    <img src="./public/image2.jpg" alt="Ritrovo per proseguire la progettazione di BelloSguardo e per lo sviluppo lato software" class="image">
                </div>
                <div class="gallery-item">
                    <img src="./public/image3.jpg" alt="Assemblaggio del primo modello, per testare il funzionamento complessivo" class="image">
                </div>
                <div class="gallery-item">
                    <img src="./public/image4.jpg" alt="Prima stampa 3D per BelloSguardo, qui in foto abbiamo l'esecuzione della stampa della base principale" class="image">
                </div>
            </div>
            <div id="modal" class="modal">
                <span class="close">&times;</span>
                <img class="modal-content" id="modal-img">
                <div id="caption"></div>
            </div>
        </section>
        <section style="display: flex; justify-content: center; align-items: center;">
            <div class="gallery">
                <div class="gallery-item">
                    <img src="./public/image5.jpg" alt="Dissaldatura e saldatura nel laboratorio di Lorenzo (il tecnico della scuola)" class="image">
                </div>
                <div class="gallery-item">
                    <img src="./public/image6.jpg" alt="Dissaldatura e saldatura nel laboratorio di Lorenzo (il tecnico della scuola)" class="image">
                </div>
                <div class="gallery-item">
                    <img src="./public/image7.jpg" alt="Continuo dell'assemblaggio e progettazione del sito web" class="image">
                </div>
                <div class="gallery-item">
                    <img src="./public/image8.jpg" alt="Esecuzione delle stampe 3D per gli ochhi di BelloSguardo" class="image">
                </div>
            </div>
            <div id="modal" class="modal">
                <span class="close">&times;</span>
                <img class="modal-content" id="modal-img">
                <div id="caption"></div>
            </div>
        </section>
        <section style="display: flex; justify-content: center; align-items: center;">
            <div class="gallery">
                <div class="gallery-item">
                    <img src="./public/image9.jpg" alt="Test finale di qualunque funzionalità di BelloSguardo" class="image">
                </div>
                <div class="gallery-item">
                    <img src="./public/image10.jpg" alt="Test e assemblaggio degli ultimi componenti" class="image">
                </div>
                <div class="gallery-item">
                    <img src="./public/image11.jpg" alt="Test dei singoli componenti di BelloSguardo" class="image">
                </div>
                <!-- <div class="gallery-item">
                    <img src="./public/image8.jpg" alt="Esecuzione delle stampe 3D per gli ochhi di BelloSguardo" class="image">
                </div> -->
            </div>
            <div id="modal" class="modal">
                <span class="close">&times;</span>
                <img class="modal-content" id="modal-img">
                <div id="caption"></div>
            </div>
        </section>
    </main>
    <?php
        require("footer.php");
    ?>
    <script src="image.js"></script>
</body>
</html>