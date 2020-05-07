<?php
//削除したコード

// メッセージを保存するファイルのパス設定
//define( 'FILENAME', './message.txt');

/*
		if( $file_handle = fopen( FILENAME, "a") ) {
			    // 書き込み日時を取得
			$now_date = date("Y-m-d H:i:s");
				// 書き込むデータを作成
			$data = "'".$clean['view_name']."','".$clean['message']."','".$now_date."'\n";
			// 書き込み
			fwrite( $file_handle, $data);
					// ファイルを閉じる
			fclose( $file_handle);
				$success_message = 'メッセージを書き込みました。';
        }*/

        /*if( $file_handle = fopen( FILENAME,'r') ) {
	while( $data = fgets($file_handle) ){
	
		$split_data = preg_split( '/\'/', $data);
	
		$message = array(
			'view_name' => $split_data[1],
			'message' => $split_data[3],
			'post_date' => $split_data[5]
		);
		array_unshift( $message_array, $message);
	}

	// ファイルを閉じる
	fclose( $file_handle);
}*/
?>