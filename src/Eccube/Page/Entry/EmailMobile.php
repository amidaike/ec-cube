<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


namespace Eccube\Page\Entry;

use Eccube\Application;
use Eccube\Page\AbstractPage;
use Eccube\Framework\CheckError;
use Eccube\Framework\Customer;
use Eccube\Framework\FormParam;
use Eccube\Framework\Query;

/**
 * 携帯メールアドレス登録のページクラス.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 */
class EmailMobile extends AbstractPage
{
    /**
     * Page を初期化する.
     *
     * @return void
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Page のプロセス.
     *
     * @return void
     */
    public function process()
    {
        parent::process();
        $this->action();
        $this->sendResponse();
    }

    /**
     * Page のアクション.
     *
     * @return void
     */
    public function action()
    {
        /* @var $objCustomer Customer */
        $objCustomer = Application::alias('eccube.customer');
        /* @var $objFormParam FormParam */
        $objFormParam   = Application::alias('eccube.form_param');

        $this->lfInitParam($objFormParam);
        $objFormParam->setParam($_POST);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->arrErr = $this->lfCheckError($objFormParam);

            if (empty($this->arrErr)) {
                $email_mobile = $this->lfRegistEmailMobile(strtolower($objFormParam->getValue('email_mobile')),
                    $objCustomer->getValue('customer_id'));

                $objCustomer->setValue('email_mobile', $email_mobile);
                $this->tpl_mainpage = 'entry/email_mobile_complete.tpl';
                $this->tpl_title = '携帯メール登録完了';
            }
        }

        $this->tpl_name = $objCustomer->getValue('name01');
        $this->arrForm  = $objFormParam->getFormParamList();
    }

    /**
     * lfInitParam
     *
     * @access public
     * @param FormParam $objFormParam
     * @return void
     */
    public function lfInitParam(&$objFormParam)
    {
        $objFormParam->addParam('メールアドレス', 'email_mobile', null, 'a',
                                array('NO_SPTAB', 'EXIST_CHECK', 'CHANGE_LOWER', 'EMAIL_CHAR_CHECK', 'EMAIL_CHECK', 'MOBILE_EMAIL_CHECK'));
    }

    /**
     * エラーチェックする
     *
     * @param FormParam $objFormParam
     * @access private
     * @return array エラー情報の配列
     */
    public function lfCheckError(&$objFormParam)
    {
        $objFormParam->convParam();
        /* @var $objErr CheckError */
        $objErr = Application::alias('eccube.check_error');
        $objErr->arrErr = $objFormParam->checkError();

        // FIXME: lfInitParam() で設定すれば良いように感じる
        $objErr->doFunc(array('メールアドレス', 'email_mobile'), array('CHECK_REGIST_CUSTOMER_EMAIL'));

        return $objErr->arrErr;
    }

    /**
     *
     * 携帯メールアドレスが登録されていないユーザーに携帯アドレスを登録する
     *
     * 登録完了後にsessionのemail_mobileを更新する
     *
     * @access private
     * @param string $email_mobile
     * @return string
     */
    public function lfRegistEmailMobile($email_mobile, $customer_id)
    {
        $objQuery = Application::alias('eccube.query');
        $objQuery->update('dtb_customer',
                          array('email_mobile' => $email_mobile),
                          'customer_id = ?', array($customer_id));

        return $email_mobile;
    }
}
