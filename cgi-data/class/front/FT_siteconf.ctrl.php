<?php
//----------------------------------------------------------------------------
// 作成日: 2019/12/28
// 作成者: 岡田
// 内  容:  サイト設定クラス
//----------------------------------------------------------------------------

//-------------------------------------------------------
//  クラス
//-------------------------------------------------------
class FT_siteconf {

	//-------------------------------------------------------
	//  変数宣言
	//-------------------------------------------------------
	// DB接続
	var $_DBconn = null;

	// 主テーブル
	var $_CtrTable   = "mst_siteconf";
	var $_CtrTablePk = "id";

	// コントロール機能（ログ用）
	var $_CtrLogName = "サイト設定";


	//-------------------------------------------------------
	// 関数名: __construct
	// 引  数: $dbconn  :  DB接続オブジェクト
	// 戻り値: なし
	// 内  容: コンストラクタ
	//-------------------------------------------------------
	function __construct( $dbconn ) {

		// クラス宣言
		if( !empty( $dbconn ) ) {
			$this->_DBconn  = $dbconn;
		} else {
			$this->_DBconn  = new DB_manage( _DNS );
		}

	}


	//-------------------------------------------------------
	// 関数名: __destruct
	// 引  数: なし
	// 戻り値: なし
	// 内  容: デストラクタ
	//-------------------------------------------------------
	function __destruct() {

	}


	//-------------------------------------------------------
	// 関数名: GetIdRow
	// 引  数: $id   - ID
	// 戻り値: 1件分
	// 内  容: 1件取得する
	//-------------------------------------------------------
	function GetIdRow( $id = 1 ) {

		// データチェック
		if( !is_numeric( $id ) ) {
			return null;
		}

		// SQL配列
		$creation_kit = array( "select" => "*",
							   "from"   => $this->_CtrTable,
							   "where"  => $this->_CtrTablePk . " = " . $id
							);

		// データ取得
		$res = $this->_DBconn->selectCtrl( $creation_kit, array("fetch" => _DB_FETCH) );

		// 戻り値
		return $res;

	}

}
?>