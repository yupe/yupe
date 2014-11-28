<?php

/**
 * Class for sms.ru
 *
 * @package smsru
 * @author  Aleksandr Zelenin <aleksandr@zelenin.me>
 * @link    https://github.com/zelenin/sms_ru
 * @license MIT
 * @version 1.4.0
 */

namespace Zelenin;

class smsru
{
	const VERSION = '1.4.0';
	const HOST = 'http://sms.ru/';
	const SEND = 'sms/send?';
	const STATUS = 'sms/status?';
	const COST = 'sms/cost?';
	const BALANCE = 'my/balance?';
	const LIMIT = 'my/limit?';
	const SENDERS = 'my/senders?';
	const GET_TOKEN = 'auth/get_token';
	const CHECK = 'auth/check?';
	const ADD = 'stoplist/add?';
	const DEL = 'stoplist/del?';
	const GET = 'stoplist/get?';
	const UCS = 'sms/ucs?';
	private $_api_id;
    private $_sender;
	private $_login;
	private $_password;
	private $_params;
	private $_token;
	private $_sha512;
	protected $response_code = array(
		'send' => array(
			'100' => 'Сообщение принято к отправке. На следующих строчках вы найдете идентификаторы отправленных сообщений в том же порядке, в котором вы указали номера, на которых совершалась отправка.',
			'200' => 'Неправильный api_id',
			'201' => 'Не хватает средств на лицевом счету',
			'202' => 'Неправильно указан получатель',
			'203' => 'Нет текста сообщения',
			'204' => 'Имя отправителя не согласовано с администрацией',
			'205' => 'Сообщение слишком длинное (превышает 8 СМС)',
			'206' => 'Будет превышен или уже превышен дневной лимит на отправку сообщений',
			'207' => 'На этот номер (или один из номеров) нельзя отправлять сообщения, либо указано более 100 номеров в списке получателей',
			'208' => 'Параметр time указан неправильно',
			'209' => 'Вы добавили этот номер (или один из номеров) в стоп-лист',
			'210' => 'Используется GET, где необходимо использовать POST',
			'211' => 'Метод не найден',
			'220' => 'Сервис временно недоступен, попробуйте чуть позже.',
			'300' => 'Неправильный token (возможно истек срок действия, либо ваш IP изменился)',
			'301' => 'Неправильный пароль, либо пользователь не найден',
			'302' => 'Пользователь авторизован, но аккаунт не подтвержден (пользователь не ввел код, присланный в регистрационной смс)'
		),
		'status' => array(
			'-1' => 'Сообщение не найдено.',
			'100' => 'Сообщение находится в нашей очереди',
			'101' => 'Сообщение передается оператору',
			'102' => 'Сообщение отправлено (в пути)',
			'103' => 'Сообщение доставлено',
			'104' => 'Не может быть доставлено: время жизни истекло',
			'105' => 'Не может быть доставлено: удалено оператором',
			'106' => 'Не может быть доставлено: сбой в телефоне',
			'107' => 'Не может быть доставлено: неизвестная причина',
			'108' => 'Не может быть доставлено: отклонено',
			'200' => 'Неправильный api_id',
			'210' => 'Используется GET, где необходимо использовать POST',
			'211' => 'Метод не найден',
			'220' => 'Сервис временно недоступен, попробуйте чуть позже.',
			'300' => 'Неправильный token (возможно истек срок действия, либо ваш IP изменился)',
			'301' => 'Неправильный пароль, либо пользователь не найден',
			'302' => 'Пользователь авторизован, но аккаунт не подтвержден (пользователь не ввел код, присланный в регистрационной смс)'
		),
		'cost' => array(
			'100' => 'Запрос выполнен. На второй строчке будет указана стоимость сообщения. На третьей строчке будет указана его длина.',
			'200' => 'Неправильный api_id',
			'202' => 'Неправильно указан получатель',
			'207' => 'На этот номер нельзя отправлять сообщения',
			'210' => 'Используется GET, где необходимо использовать POST',
			'211' => 'Метод не найден',
			'220' => 'Сервис временно недоступен, попробуйте чуть позже.',
			'300' => 'Неправильный token (возможно истек срок действия, либо ваш IP изменился)',
			'301' => 'Неправильный пароль, либо пользователь не найден',
			'302' => 'Пользователь авторизован, но аккаунт не подтвержден (пользователь не ввел код, присланный в регистрационной смс)'
		),
		'balance' => array(
			'100' => 'Запрос выполнен. На второй строчке вы найдете ваше текущее состояние баланса.',
			'200' => 'Неправильный api_id',
			'210' => 'Используется GET, где необходимо использовать POST',
			'211' => 'Метод не найден',
			'220' => 'Сервис временно недоступен, попробуйте чуть позже.',
			'300' => 'Неправильный token (возможно истек срок действия, либо ваш IP изменился)',
			'301' => 'Неправильный пароль, либо пользователь не найден',
			'302' => 'Пользователь авторизован, но аккаунт не подтвержден (пользователь не ввел код, присланный в регистрационной смс)'
		),
		'limit' => array(
			'100' => 'Запрос выполнен. На второй строчке вы найдете ваше текущее дневное ограничение. На третьей строчке количество сообщений, отправленных вами в текущий день.',
			'200' => 'Неправильный api_id',
			'210' => 'Используется GET, где необходимо использовать POST',
			'211' => 'Метод не найден',
			'220' => 'Сервис временно недоступен, попробуйте чуть позже.',
			'300' => 'Неправильный token (возможно истек срок действия, либо ваш IP изменился)',
			'301' => 'Неправильный пароль, либо пользователь не найден',
			'302' => 'Пользователь авторизован, но аккаунт не подтвержден (пользователь не ввел код, присланный в регистрационной смс)'
		),
		'senders' => array(
			'100' => 'Запрос выполнен. На второй и последующих строчках вы найдете ваших одобренных отправителей, которые можно использовать в параметре &from= метода sms/send.',
			'200' => 'Неправильный api_id',
			'210' => 'Используется GET, где необходимо использовать POST',
			'211' => 'Метод не найден',
			'220' => 'Сервис временно недоступен, попробуйте чуть позже.',
			'300' => 'Неправильный token (возможно истек срок действия, либо ваш IP изменился)',
			'301' => 'Неправильный пароль, либо пользователь не найден',
			'302' => 'Пользователь авторизован, но аккаунт не подтвержден (пользователь не ввел код, присланный в регистрационной смс)'
		),
		'check' => array(
			'100' => 'ОК, номер телефона и пароль совпадают.',
			'300' => 'Неправильный token (возможно истек срок действия, либо ваш IP изменился)',
			'301' => 'Неправильный пароль, либо пользователь не найден',
			'302' => 'Пользователь авторизован, но аккаунт не подтвержден (пользователь не ввел код, присланный в регистрационной смс)'
		),
		'add' => array(
			'100' => 'Номер добавлен в стоплист.',
			'202' => 'Номер телефона в неправильном формате'
		),
		'del' => array(
			'100' => 'Номер удален из стоплиста.',
			'202' => 'Номер телефона в неправильном формате'
		),
		'get' => array(
			'100' => 'Запрос обработан. На последующих строчках будут идти номера телефонов, указанных в стоплисте в формате номер;примечание.'
		)

	);

	public function  __construct( $api_id = null, $login = null, $pwd = null )
	{
		$this->_api_id = $api_id;
		$this->_login = $login;
		$this->_password = $pwd;

		$this->_params = $this->getAuthParams();
	}

    public function setSender ($sender = null)
    {
        $this->_sender = $sender;
    }

	public function sms_send( $to, $text, $from = null, $time = null, $translit = false, $test = false, $partner_id = null )
	{
		$messages = array( array( $to, $text ) );
		return $this->multi_sms_send( $messages, $from, $time, $translit, $test, $partner_id );
	}

	public function multi_sms_send( $messages, $from = null, $time = null, $translit = false, $test = false, $partner_id = null )
	{
		$url = self::HOST . self::SEND;
		$params = $this->_params;

		foreach ( $messages as $message ) {
			$params['multi'][$message[0]] = $message[1];
		}

		if ( $from ) {
			$params['from'] = $from;
		}

        if ($from == null)
        {
            $params['from'] = $this->_sender;
        }

		if ( $time && $time < ( time() + 7 * 60 * 60 * 24 ) ) {
			$params['time'] = $time;
		}

		if ( $translit ) {
			$params['translit'] = 1;
		}

		if ( $test ) {
			$params['test'] = 1;
		}

		if ( $partner_id ) {
			$params['partner_id'] = $partner_id;
		}

		$result = $this->curl( $url, http_build_query( $params ) );
		$result = explode( "\n", $result );

		$response = array();
		$response['code'] = array_shift( $result );
		$response['description'] = $this->getAnswer( 'send', $response['code'] );

		if ( $response['code'] == 100 ) {
			foreach ( $result as $id ) {
				if ( !preg_match( '/=/', $id ) ) {
					$response['ids'][] = $id;
				} else {
					$result = explode( '=', $id );
					$response[$result[0]] = $result[1];
				}
			}
		}
		return $response;
	}

	public function sms_mail( $to, $text, $from = null )
	{
		$mail = $this->_api_id . '@' . self::HOST;
		$subject = isset( $from ) ? $to . ' from:' . $from : $to;
		$headers = 'Content-Type: text/html; charset=UTF-8';
		return mail( $mail, $subject, $text, $headers );
	}

	public function sms_status( $id )
	{
		$url = self::HOST . self::STATUS;
		$params = $this->_params;
		$params['id'] = $id;
		$result = $this->curl( $url, $params );

		$response = array();
		$response['code'] = $result;
		$response['description'] = $this->getAnswer( 'status', $response['code'] );
		return $response;
	}

	public function sms_cost( $to, $text )
	{
		$url = self::HOST . self::COST;
		$params = $this->_params;
		$params['to'] = $to;
		$params['text'] = $text;

		$result = $this->curl( $url, $params );
		$result = explode( "\n", $result );

		return array(
			'code' => $result[0],
			'description' => $this->getAnswer( 'cost', $result[0] ),
			'price' => $result[1],
			'number' => $result[2]
		);
	}

	public function my_balance()
	{
		$url = self::HOST . self::BALANCE;
		$params = $this->_params;
		$result = $this->curl( $url, $params );
		$result = explode( "\n", $result );
		return array(
			'code' => $result[0],
			'description' => $this->getAnswer( 'balance', $result[0] ),
			'balance' => $result[1]
		);
	}

	public function my_limit()
	{
		$url = self::HOST . self::LIMIT;
		$params = $this->_params;
		$result = $this->curl( $url, $params );
		$result = explode( "\n", $result );
		return array(
			'code' => $result[0],
			'description' => $this->getAnswer( 'limit', $result[0] ),
			'total' => $result[1],
			'current' => $result[2]
		);
	}

	public function my_senders()
	{
		$url = self::HOST . self::SENDERS;
		$params = $this->_params;
		$result = $this->curl( $url, $params );
		$result = explode( "\n", rtrim( $result ) );

		$response = array(
			'code' => $result[0],
			'description' => $this->getAnswer( 'senders', $result[0] ),
			'senders' => $result
		);
		unset( $response['senders'][0] );
		$response['senders'] = array_values( $response['senders'] );
		return $response;
	}

	public function auth_check()
	{
		$url = self::HOST . self::CHECK;
		$params = $this->_params;
		$result = $this->curl( $url, $params );

		$response = array();
		$response['code'] = $result;
		$response['description'] = $this->getAnswer( 'check', $response['code'] );
		return $response;
	}

	public function stoplist_add( $stoplist_phone, $stoplist_text )
	{
		$url = self::HOST . self::ADD;
		$params = $this->_params;
		$params['stoplist_phone'] = $stoplist_phone;
		$params['stoplist_text'] = $stoplist_text;
		$result = $this->curl( $url, $params );

		$response = array();
		$response['code'] = $result;
		$response['description'] = $this->getAnswer( 'add', $response['code'] );
		return $response;
	}

	public function stoplist_del( $stoplist_phone )
	{
		$url = self::HOST . self::DEL;
		$params = $this->_params;
		$params['stoplist_phone'] = $stoplist_phone;
		$result = $this->curl( $url, $params );

		$response = array();
		$response['code'] = $result;
		$response['description'] = $this->getAnswer( 'del', $response['code'] );
		return $response;
	}

	public function stoplist_get()
	{
		$url = self::HOST . self::GET;
		$params = $this->_params;
		$result = $this->curl( $url, $params );

		$result = explode( "\n", rtrim( $result ) );
		$response = array(
			'code' => $result[0],
			'description' => $this->getAnswer( 'get', $result[0] ),
			'stoplist' => $result
		);
		$count = count( $response['stoplist'] );
		for ( $i = 1; $i < $count; $i++ ) {
			$result = explode( ';', $response['stoplist'][$i] );
			$stoplist[$i - 1]['number'] = $result[0];
			$stoplist[$i - 1]['note'] = $result[1];
		}
		$response['stoplist'] = $stoplist;
		return $response;
	}

	public function sms_ucs()
	{
		$url = self::HOST . self::UCS;
		$params = $this->_params;
		$result = $this->curl( $url, $params );
		return $result;
	}

	private function getAuthParams()
	{
		if ( !empty( $this->login ) && !empty( $this->pwd ) ) {
			$this->_token = $this->authGetToken();
			$this->_sha512 = $this->getSha512();

			$params['login'] = $this->_login;
			$params['token'] = $this->_token;
			$params['sha512'] = $this->_sha512;
		} else {
			$params['api_id'] = $this->_api_id;
		}
		return $params;
	}

	private function authGetToken()
	{
		$url = self::HOST . self::GET_TOKEN;
		return $this->curl( $url );
	}

	private function getSha512()
	{
		if ( !$this->_api_id || empty( $this->_api_id ) ) {
			return hash( 'sha512', $this->_password . $this->_token );
		} else {
			return hash( 'sha512', $this->_password . $this->_token . $this->_api_id );
		}
	}

	private function getAnswer( $key, $code )
	{
		if ( isset( $this->response_code[$key][$code] ) ) {
			return $this->response_code[$key][$code];
		}
	}

	private function curl( $url, $params = array() )
	{
		$ch = curl_init( $url );
		$options = array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_POSTFIELDS => $params
		);
		curl_setopt_array( $ch, $options );
		$result = curl_exec( $ch );
		curl_close( $ch );

		return $result;
	}
}
