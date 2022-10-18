<?
include("main.php");
$user = db_find_user_by_steamid64((int)$_SESSION['steam_id']);
$steam = new stdClass;
if ($user != false) {
    $steam = get_info_by_steam64id((int)$user->steam_id);
}
$stats = json_decode(file_get_contents("more/stats.json"));
$q_modes = qr("SELECT * FROM `modes`");
$q_servers = qr("SELECT * FROM `servers`");
$mods_players = $stats->mods;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div>
            <a href="<? echo LINKS['vk']; ?>"">
                <i class=" fab fa-vk fa-sm"></i>
            </a>
            <a href="<? echo LINKS['inst']; ?>">
                <i class="fab fa-instagram fa-sm"></i>
            </a>
            </a>
            <a href="<? echo LINKS['discord']; ?>">
                <i class="fab fa-discord fa-sm"></i>
            </a>
            <a href="../premium" class="txt_get_premium">
                <i class="fal fa-crown fa-sm"></i> &nbsp;ПОЛУЧИТЬ PREMIUM
            </a>
        </div>
        <div class="project_logo">
            <div><img src="/img/logo.webp" /></div>
            <div>•</div>
            <div><? echo $stats->players_now; ?></div>
        </div>
        <div>
            <?
      if ($user != false) :
        ?>
            <div class="_user_balance"><? echo $user->balance; ?> ₽</div>
            <div id="btn_add_balance"><button><i class="fal fa-plus"></i> &nbsp;Пополнить</button></div>
            <div><button><i class="far fa-bell fa-lg"></i></button></div>
            <div img_user>
                <img src="<? echo $steam->avatarmedium; ?>" alt="">
                <div class="profile-tab">
                    <div s1>
                        <div>
                            <img src="<? echo $steam->avatarmedium; ?>">
                        </div>
                        <div>
                            <p><a href="profile"><? echo $steam->personaname; ?></a></p>
                            <p><a href="profile">Перейти в профиль</a></p>
                        </div>
                    </div>
                    <div s2>
                        <p><a href=""><i class="fad fa-briefcase"></i> &nbsp;&nbsp;Инвентарь</a></p>
                        <p><a href=""><i class="fas fa-cog"></i> &nbsp;&nbsp;Настройки</a></p>
                    </div>
                    <div s3>
                        <p><a href="../logout"><i class="fal fa-sign-out"></i> &nbsp;&nbsp;Выйти</a></p>
                    </div>
                </div>
            </div>
            <span img_user arrows><i class="fal fa-chevron-down"></i>
    </div>
<?
        endif;
            if ($user == false) :
            ?>
                <a href="<? echo steam_auth_login_url(); ?>">
                    <div class="steam_login_btn">
                        Войти через STEAM &nbsp;<i class="fab fa-steam"></i>
                    </div>
                </a>
            <?
            endif;
            ?>
        </div>
    </header>
    <div class="main">
        <div class="menu">
            <li class="li-active"><a href="https://<? echo $_SERVER['HTTP_HOST']; ?>"><i class="fas fa-play fa-lg"></i></a></li>
            <li><a href="../premium"><i class="fas fa-crown fa-lg"></i></a></li>
            <li><a href="../faq"><i class="fas fa-user-headset fa-lg"></i></a></li>
            <li class="t_lang">
                <div>
                    Язык
                </div>
                <img src="/img/ru_flag.svg" alt="">
            </li>
        </div>
        <div class="content">
            <div class="cards">
                <?
                for ($i = 0; $i < qr_num($q_modes); $i++) {
                    $mode = qr_res($q_modes);
                    echo '<div class="card" img="/img/' . $mode->name_img . '" id_mode="' . $mode->id . '">';
                    if ($mode->visible == 0) {
                        echo '<div class="card-lock"><i class="far fa-lock-alt fa-7x"></i></div>';
                    } else {
                        echo '<div class="card-lock"></div>';
                    }
                    $pos_mode = (int)($mode->id) - 1;
                    echo '<div class="card-info">' . $mode->description . '</div>';
                    echo '<div class="card-name">' . $mode->name . '</div>';
                    if ($mode->visible == 1) {
                        echo '<div class="card-players">' . $mods_players[$pos_mode]->players . ' В игре </div>';
                    }
                    echo '</div>';
                }
                ?>
            </div>
            <div class="sponsors">
                <a href=""> <img src="/img/sp.svg" alt=""></a>
            </div>
            <div class="stats">
                <p><span><? echo $stats->players; ?></span> &nbsp;&nbsp;ИГРОКОВ</p>
                <p><span><? echo $stats->player24h; ?></span> &nbsp;&nbsp;ИГРОКОВ В СУТКИ</p>
                <p><span><? echo $stats->new_players; ?></span> &nbsp;&nbsp;НОВЫХ ИГРОКОВ</p>
                <p><span><? echo qr_num($q_servers); ?></span> &nbsp;&nbsp;СЕРВЕРОВ</p>
                <p><span><? echo qr_num($q_modes); ?></span> &nbsp;&nbsp;РЕЖИМОВ</p>
            </div>
            <div class="block_with_links">
                <a href="../">играть</a>
                <a href="../premium">PREMIUM</a>
                <a href="../faq">ПОМОЩЬ</a>
                <a href="">КОНТАКТЫ</a>
                <a href="../tos">ПОЛЬЗОВАТЕЛЬСКОЕ СОГЛАШЕНИЕ</a>
            </div>
            <div class="i_block_with_links">
                <a href="<? echo LINKS['vk']; ?>">
                    <i class="fab fa-vk fa-lg"></i>
                </a>
                <a href="<? echo LINKS['inst']; ?>">
                    <i class="fab fa-instagram fa-lg"></i>
                </a>
                </a>
                <a href="<? echo LINKS['discord']; ?>">
                    <i class="fab fa-discord fa-lg"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="agree" <? echo tos(); ?>>
        <div class="agree_block">
            <div>
                <img src="../img/logo.svg" alt="">
            </div>
            <div>
                <p>Подтвердите согласие</p>
            </div>
            <div>
                <p>Я подтверждаю, что мне больше 18 лет</p>
                <p>Я принимаю условия <a href='tos'>Пользовательского Соглашения</a></p>
            </div>
            <div>
                <button agree_accept>Принять</button>
                <button agree_decline>Отклонить</button>
            </div>
        </div>
    </div>
    <div class="add-balance">
        <div class="add-balance_block">
            <div>
                <div>Пополнение баланса</div>
                <div>✕</div>
            </div>
            <div class="payments">
                <div payment="card">
                    <img src="../img/cards.svg" alt="">
                </div>
                <div payment="qiwi"><img src="../img/qiwi.svg" alt=""></div>
                <div payment="yoomoney"><img src="../img/yoomoney.svg" alt=""></div>
            </div>
            <div><input type="number" input_balance placeholder="ВВЕДИТЕ СУММУ"></div>
            <div>
                <button btn_balance>ПОПОЛНИТЬ БАЛАНС</button>
            </div>
        </div>
    </div>
    <?
    include("css.php");
    ?>
    <script>
        $(document).ready(function() {
            for (let i = 0; i < $(".card").length; i++) {
                let img = $(".card").eq(i).attr("img");
                $(".card").eq(i).css("background", "linear-gradient(rgba(20, 23, 27,.5), rgba(20, 23, 27,.5)), url('" + img + ".png')");
                if ($(".card").eq(i).find(".card-lock").html().length < 3) {
                    $(".card").eq(i).css("justify-content", "end");
                    $(".card").eq(i).find('.card-players').css("margin-bottom", "2em");
                }
            }
        });
        $(".card").hover(
            function() {
                var src = $(this).attr("img");
                $(this).css("background", "linear-gradient(rgba(20, 23, 27,0.9), rgba(20, 23, 27,0.9)), url('" + src + ".gif')");
                $(this).find(".card-lock").hide();
                $(this).find(".card-info").show();
                $(this).find('.card-players').hide().css("margin-bottom", "0");
                $(this).css("justify-content", "space-evenly");
            },
            function() {
                var src = $(this).attr("img");
                $(this).find(".card-lock").show();
                $(this).css("background", "linear-gradient(rgba(20, 23, 27,.5), rgba(20, 23, 27,.5)), url('" + src + ".png')");
                $(this).find(".card-info").hide();
                if ($(this).find(".card-lock").html().length < 3) {
                    $(this).css("justify-content", "end");
                    $(this).find('.card-players').show().css("margin-bottom", "2em");
                }

            });
        $("[id_mode]").click(function() {
            location = "../mod/" + $(this).attr("id_mode");
        });
        $("[img_user]").click(
            function() {
                var src = $(this).attr("img");
                $(".profile-tab").fadeToggle();
            }
        );
        $("[s3]").click(function() {
            location = "../logout.php";
        });
        $('.main').click(function() {
            $(".profile-tab").hide();
        });
        $(".project_logo").click(function() {
            location = "<? echo "https://" . $_SERVER['HTTP_HOST']; ?>";
        });
        $("[agree_accept]").click(function() {
            location = "../tos_accept";
        });
        $("[agree_decline]").click(function() {
            location = "https://google.com";
        });
        $("#btn_add_balance").click(function() {
            $('.add-balance').css("display", "flex").hide().fadeIn(300);

        });
        $("div.add-balance > div > div:nth-child(1)").click(function() {
            $('.add-balance').fadeOut(300, function() {
                $('.add-balance_block').css('z-index', '1');
            })
        });
        $(".payments > div").click(function() {
            $(".payments > div").removeAttr("active");
            $(this).attr("active", "");
        });
        $("[btn_balance]").click(function() {
            $(this).prop("disabled", true);
            var handler_id = "add_money";
            var sum = $("[input_balance]").val();
            var payment = $(".payments > [active]").attr("payment");
            if (payment == null) {
                alert("Выберите метод платежа")
                return;
            }
            if (sum == '') {
                alert("Введите сумму для пополнения")
                return;
            }
            $.ajax({
                type: 'POST',
                url: 'handler.php',
                data: {
                    handler_id,
                    payment,
                    sum
                },
                success: function(result) {
                    location = result;
                }
            })
        });
    </script>
</body>

</html>