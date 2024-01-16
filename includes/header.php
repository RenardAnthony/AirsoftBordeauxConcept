


<div id="top-header">
    <a href="../pages/index.php"><img id="logo" src="../assets/images/theme/logo.png" alt="logo airsoft"></a>
    <nav>
        <ul>
            <li><a href="../pages/calendrier.php">Calendrier</a></li>
            <li><a href="https://airsoftbordeauxforum.forum-pro.fr">Forum</a></li>
            <li><a href="">Contact</a></li>
        </ul>
    </nav>


    <?php if(isset($_SESSION['id'])){ ?>
        <a href="../pages/profil.php?id=<?=$selfuser_id?>">
            <div id="btn_connect">
                <img id="pdp" src="../assets/images/avatars/<?=$selfuser_avatar?>" alt="">
                <p><?=$selfuser_username?></p>
            </div>
        </a>
    <?php }else{ ?>
        <a href="../pages/connection.php">
            <div id="btn_connect">
                <img id="pdp" src="../assets/images/theme/profil_default.png" alt="">
                <p>Connection</p>
            </div>
        </a>
    <?php } ?>
</div>