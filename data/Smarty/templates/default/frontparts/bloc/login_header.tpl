<script type="text/javascript">//<![CDATA[
    $(function(){
        var $login_email = $('#header_login_area input[name=login_email]');

        if (!$login_email.val()) {
            $login_email
                .val('メールアドレス')
                .css('color', '#AAA');
        }

        $login_email
            .focus(function() {
                if ($(this).val() == 'メールアドレス') {
                    $(this).val('')
                           .css('color', '#000');
                }
            })
            .blur(function() {
                if (!$(this).val()) {
                    $(this).val('メールアドレス')
                           .css('color', '#AAA');
                }
            });

        $('#header_login_form').submit(function() {
            if (!$login_email.val()
                || $login_email.val() == 'メールアドレス') {
                if ($('#header_login_area input[name=login_pass]').val()) {
                    alert('メールアドレス/パスワードを入力して下さい。');
                }
                return false;
            }
            return true;
        });
    });
//]]>
</script>
<div class="bloc_outer">
    <div id="header_login_area" class="clearfix">
        <form name="header_login_form" id="header_login_form" method="post" action="<!--{$smarty.const.HTTPS_URL}-->frontparts/login_check.php" onsubmit="return fnCheckLogin('header_login_form')">
        <input type="hidden" name="mode" value="login" />
        <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
        <input type="hidden" name="url" value="<!--{$smarty.server.PHP_SELF|h}-->" />
        <div class="bloc_body clearfix">
            <!--{if $tpl_login}-->
                <!--{if !$tpl_disable_logout}-->
                    <p class="btn">
                        ようこそ
                        <span class="user_name"><!--{$tpl_name1|h}--> <!--{$tpl_name2|h}--> 様</span> /
                        <!--{if $smarty.const.USE_POINT !== false}-->
                            所持ポイント: <span class="point"> <!--{$tpl_user_point|number_format|default:0}--> pt</span>
                        <!--{/if}-->&nbsp;&nbsp;
                        <input type="image" onmouseover="chgImgImageSubmit('<!--{$TPL_URLPATH}-->img/common/btn_header_logout_on.jpg',this)" onmouseout="chgImgImageSubmit('<!--{$TPL_URLPATH}-->img/common/btn_header_logout.jpg',this)" src="<!--{$TPL_URLPATH}-->img/common/btn_header_logout.jpg" onclick="fnFormModeSubmit('header_login_form', 'logout', '', ''); return false;" alt="ログアウト" />
                    </p>
                <!--{/if}-->
            <!--{else}-->
                <ul class="formlist clearfix">
                    <li class="mail">
                        <input type="text" class="box150" name="login_email" value="<!--{$tpl_login_email|h}-->" style="ime-mode: disabled;" title="メールアドレスを入力して下さい" />
                    </li>
                    <li class="login_memory">
                        <input type="checkbox" name="login_memory" id="header_login_memory" value="1" <!--{$tpl_login_memory|sfGetChecked:1}--> /><label for="header_login_memory"><span>記憶</span></label>
                    </li>
                    <li class="password"><input type="password" class="box100" name="login_pass" title="パスワードを入力して下さい" /></li>
                    <li class="btn">
                        <input type="image" onmouseover="chgImgImageSubmit('<!--{$TPL_URLPATH}-->img/common/btn_header_login_on.jpg',this)" onmouseout="chgImgImageSubmit('<!--{$TPL_URLPATH}-->img/common/btn_header_login.jpg',this)" src="<!--{$TPL_URLPATH}-->img/common/btn_header_login.jpg" />
                    </li>
                    <li class="forgot">
                        <a href="<!--{$smarty.const.HTTPS_URL|sfTrimURL}-->/forgot/<!--{$smarty.const.DIR_INDEX_PATH}-->" onclick="win01('<!--{$smarty.const.HTTPS_URL|sfTrimURL}-->/forgot/<!--{$smarty.const.DIR_INDEX_PATH}-->','forget','600','400'); return false;" target="_blank">パスワードを忘れた方</a>
                    </li>
                </ul>

            <!--{/if}-->
        </div>
        </form>
    </div>
</div>