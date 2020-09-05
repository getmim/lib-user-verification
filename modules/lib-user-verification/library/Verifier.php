<?php
/**
 * Verifier
 * @package lib-user-verification
 * @version 0.0.1
 */

namespace LibUserVerification\Library;

use LibUserVerification\Model\UserVerification as UVerification;

class Verifier
{
	private static $last_error;

	private static function generateToken(string $type, int $length): string{
		$chars_opt = [
			'number' => '0123456789',
			'text'   => 'abcdefghijklmnopqrstuvwxyz0123456789'
		];

		$chars = $chars_opt[$type];

		$result = '';
		for($i=0; $i<$length; $i++){
			$chars = str_shuffle($chars);
			$result.= substr($chars, 1, 1);
		}

		return $result;
	}

	static function generate(string $user, string $field, string $value, array $options=[]): ?string{
		$opt_deff = [
			'next'   => null,
			'type'   => 'text', // text|number
			'length' => 32,
			'expires'=> '+2 hours'
		];
		foreach($opt_deff as $key => $val)
			$options[$key] = $options[$key] ?? $val;

		$options['expires'] = date('Y-m-d H:i:s', strtotime($options['expires']));

		$re = $options['type'] == 'text' ? '[a-z0-9]' : '[0-9]';
		$re.= '{' . $options['length'] . '}';
		$re = '!' . $re . '!';

		$cond  = ['user'=>$user,'field'=>$field,'value'=>$value];
		$verif = UVerification::getOne($cond);

		if($verif){
			if(!$options['next'])
				$options['next'] = $verif->next;

			// make sure the token rule match
			if(preg_match($re,$verif->token)){
				if($verif->validated){
					self::$last_error = 'Provided data already verified';
					return null;
				}

				UVerification::set(['expires'=>$options['expires']], ['id'=>$verif->id]);

				return $verif->token;
			}
		}

		$new_verif = [
			'user'      => $user,
			'field'     => $field,
			'value'     => $value,
			'next'      => $options['next'],
			'validated' => null,
			'token'     => null,
			'expires'   => $options['expires']
		];

		while(true){
			$new_verif['token'] = self::generateToken($options['type'], $options['length']);
			if(!UVerification::getOne(['token'=>$new_verif['token']]))
				break;
		}

		if($verif){
			$verif_id = $verif->id;
			UVerification::set($new_verif, ['id'=>$verif_id]);
		}else{
			$verif_id = UVerification::create($new_verif);
		}

		return $new_verif['token'];
	}

	static function lastError(): ?string{
		return self::$last_error;
	}

	static function verify(string $token, string $field, string $value=null, int $user=null): ?object{
		$cond = ['token'=>$token, 'field'=>$field];
		if($user)
			$cond['user'] = $user;
		if($value)
			$cond['value'] = $value;

		$verif = UVerification::getOne($cond);
		if(!$verif)
			return null;

		$expires = strtotime($verif->expires);
		if($expires < time())
			return null;

		// confirmed
		$set_verif = [
			'validated' => date('Y-m-d H:i:s'),
			'token'     => time() . '#' . $verif->token
		];

		$verif->validated = $set_verif['validated'];

		UVerification::set($set_verif, ['id'=>$verif->id]);

		return $verif;
	}
}