/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
    config.height = '40vh';
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.extraPlugins = 'youtube';
    // config.allowedContent = true;
    config.removeDialogTabs = 'link:upload;image:Upload;;flash:Upload';
    config.fontSize_sizes = '4/4px;5/5px;6/6px;7/7px;8/8px;9/9px;10/10px;11/11px;12/12px;13/13px;14/14px;' +
        '15/15px;16/16px;17/17px;18/18px;19/19px;20/20px;21/21px;22/22px;23/23px;' +
        '24/24px;25/25px;26/26px;27/27px;28/28px;29/29px;30/30px;31/31px;32/32px;' +
        '33/33px;34/34px;35/35px;36/36px;37/37px;38/38px;39/39px;40/40px;41/41px;' +
        '42/42px;43/43px;44/44px;45/45px;46/46px;47/47px;48/48px;49/49px;50/50px;' +
        '51/51px;52/52px;53/53px;54/54px;55/55px;56/56px;57/57px;58/58px;59/59px;' +
        '60/60px;61/61px;62/62px;63/63px;64/64px;65/65px;66/66px;67/67px;68/68px;' +
        '69/69px;70/70px;71/71px;72/72px;73/73px;74/74px;75/75px;76/76px;77/77px;' +
        '78/78px;79/79px;80/80px;81/81px;82/82px;83/83px;84/84px;85/85px;86/86px;' +
        '87/87px;88/88px;89/89px;90/90px';
    config.enterMode = CKEDITOR.ENTER_BR; //newline behavior
    config.height = 500;

};
