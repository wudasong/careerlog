<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/private';
	
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	
	/**
	 * @var array site languages items. 
	 */
	public $siteLanguages=array('zh_cn', 'en_us');
	
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	/**
	 * @var bool Returns if the user is login.
	 */	
	public $isLogin = false;
	
	/**
	 * @var string Returns the version of site. 
	 */	
	public $siteVersion = '0.3.0';
	
	/**
	* @var string Returns the name of site. 
	*/	
	public $siteName = '';
	
	/**
	* @var string Returns the page type. 
	*/	
	public $pageType = '';
	
	/**
	* Initializes the controller.
	* This method is called by the application before the controller starts to execute.
	*/
	public function init()
	{
		$this->isLogin = Yii::app()->user->isGuest === false ? true : false;
		
		if(!$this->isLogin)
			$this->layout ='//layouts/public';
		
		if(YII_DEBUG)
			$this->siteVersion .= '.'.substr(time(),6,4);
		
		$httpRequest = Yii::app()->getRequest();
		
		if (strpos($httpRequest->hostInfo, 'careerlog.cn'))
		{
			$this->siteName = 'Careerlog.cn';
			$this->setLanguageCookie($this->siteLanguages[0]);	
		}
		elseif(strpos($httpRequest->hostInfo, 'careerlog.org'))
		{
			$this->siteName = 'Careerlog.org';	
			$this->setLanguageCookie($this->siteLanguages[1]);	
		}
		else
			$this->siteName = Yii::app()->name;
		
		$this->initLanguage();
	}
	
	/**
	* Initializes the language of site
	*/
	public function initLanguage()
	{
		$httpRequest = Yii::app()->getRequest();
		$cookies = $httpRequest->getCookies();
		$lang = $httpRequest->getQuery('lang');
		
		if(isset($lang))  // check if the user is changing the language
		{
			$this->setLanguageCookie($lang);
		}
		elseif(isset($cookies['lang'])) // if not, then check if there is cookie storing the language
		{
			$cookie = $cookies['lang'];
			$lang = $cookie->value;
		}
		else // if not, then use the language of browser
		{
			$lang = $httpRequest->getPreferredLanguage();
		}
		
		if(!in_array($lang, $this->siteLanguages))  // check if our site supports that language
			$lang=Yii::app()->language;
		
		Yii::app()->setLanguage($lang);
	}
	
	/**
	 * This is a method to write $lang into cookie
	 *
	 * @param mixed $lang 
	 * @return void
	 *
	 */	
	public function setLanguageCookie($lang)
	{
		$httpRequest = Yii::app()->getRequest();
		$cookies = $httpRequest->getCookies();
		$cookie = $cookies['lang'];
		if(!isset($cookie))
		{
			$cookie = new CHttpCookie('lang',$lang);
			$cookie->expire = time()+60*60*24*365;
		}
		$cookie->value = $lang;
		$cookies->add('lang',$cookie);
	}
	
}