    <main>
        <?php
                if(isset($_SESSION['error'])) {
                    echo '<p class="error">' . $_SESSION['error'] . '</p>';
                    unset($_SESSION['error']);
                }
                if(isset($_SESSION['message'])) {
                    echo '<p class="confirmation">' . $_SESSION['message'] . '</p>';
                    unset($_SESSION['message']);
                }
            ?>
        <section class="nouveau-client none">
            <h2>Ajouter un nouveau client</h2>
            
            <form class="nouveau-client__form" action="/www/exos/t2i/app/views/home/processing/create.php" method="POST">
                <label for="nom" class="nouveau-client__label"> NOM :
                    <input type="text" name="nom">
                </label>
                <label for="prenom" class="nouveau-client__label"> Prénom :
                    <input type="text" name="prenom">
                </label>
                <label for="date" class="nouveau-client__label"> Date :
                    <input type="date" name="date">
                </label>
                <label for="tel" class="nouveau-client__label"> Tel :
                    <input type="tel" name="tel" pattern="[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}" required>
                </label>
                <small>Format: 0101010101</small>
                <label for="adresse" class="nouveau-client__label"> Adresse :
                    <input type="text" name="adresse">
                </label>
                <label for="mail" class="nouveau-client__label"> Mail :
                    <input type="email" name="mail">
                </label>
                <input class="btn" type="submit" value="Ajouter">
            </form>
        </section>
        <section class="superviseur none">
            <h2 class="superviseur__titre">Superviseur mode</h2>
            <div class="container">
                <div class="alarmes">
                    <ul class="alarmes-prises"></ul>
                    <ul class="alarmes-libres" id="alarme-libre"></ul>
                </div>
                <div class="info"></div>
            </div>
            <div class="date"></div>
        </section>
    </main>