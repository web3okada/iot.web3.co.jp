<script type="text/javascript">
	//画像のリサイズ処理
	$(window).bind('load', function() {
		resize_image(240, 180, 'resize');
	});
</script>

<?php echo form_open($this->common_form_action_base . 'submit/', array('id' => 'common_form')); ?>

<div class="alert">
	表示されている内容に問題がなければ画面下の実行ボタンを押してください。
	登録/編集を確定します。
</div>

<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="2" class="table_section">特集の設定</th>
	</tr>
</thead>
<tbody>
	<?php if ($this->column_post_title_use): ?>
	<tr>
		<th class="span4"><?php echo $this->label_post_title; ?></th>
		<td>
			<?php echo h($post_title); ?>&nbsp;
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_post_sub_title_use): ?>
	<tr>
		<th class="span4"><?php echo $this->label_post_sub_title; ?></th>
		<td>
			<?php echo h($post_sub_title); ?>&nbsp;
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_post_content_use): ?>
	<tr>
		<th class="span4"><?php echo $this->label_post_content; ?></th>
		<td>
			<?php echo h_br($post_content); ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_post_link_use): ?>
	<tr>
		<th class="span4"><?php echo $this->label_post_link; ?></th>
		<td>
			<span class="label" style="vertical-align:baseline;">URL</span>　<?php echo h($post_link); ?><br />
			<span class="label" style="vertical-align:baseline;"><?php echo $this->label_post_link_text; ?></span>　
			<?php echo h($post_link_text); ?>
		</td>
	</tr>
	<?php endif; ?>
	<tr>
		<th class="span4">表示する特集カテゴリー</th>
		<td>
			<?php echo h($this->label_list['current_special_type']); ?>
		</td>
	</tr>
<tr>
	<th>特集の表示開始日</th>
	<td>
		<?php echo h($special_start_date); ?>
	</td>
</tr><tr>
	<th>特集の表示終了日</th>
	<td>
		<?php echo h($special_end_date); ?>
	</td>
</tr>
	<!-- 追加項目セット位置 -->
</tbody>
</table>

<!-- 画像アップロードを使用する場合に表示する -->
<?php if ($this->use_image_upload): ?>

<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="2" class="table_section">画像</th>
	</tr>
</thead>
</table>
<span class="help-block">※利用できる画像の種類は「JPEG」,「PNG」です。</span>

<div class="row-fluid">
<ul id="image_sortable" class="" style="width: 100%">
	<?php $column_no_order_list = explode(',', $image_order_str); ?>
	<?php foreach ($column_no_order_list as $column_no): ?>
	<?php
		$target_form_key = "upload_image{$column_no}";	//ファイルアップロードのフォーム名称のキー
		$uploaded_file_key = "after_upload_image{$column_no}";	//セッションに保持するためにアップロード後のファイル名を保持するキー
		$file_exists_flg = "{$uploaded_file_key}_exists_flg";
		$caption_key = "image{$column_no}_caption";	//キャプション用のキー
		$paragraph_title_key = "image{$column_no}_paragraph_title";
	?>
	
		<?php if ($this->use_image_paragraph_title): ?>
		<?php if (is_not_blank($this->data[$paragraph_title_key]) && is_not_blank($this->data[$uploaded_file_key])): ?>

		<li class="conf_paragraph_title conf_paragraph_title_clear ">
			<div class="label label-success" style="height: 30px;">
				<span class="label" style="vertical-align:baseline;">章タイトル</span>　<?php echo h($this->data[$paragraph_title_key]); ?>
			</div>
		</li>
		<?php endif; ?>
		<?php endif; ?>

		<li id="tr_<?php echo $column_no; ?>" class="<?php echo ($this->use_image_caption) ? 'sortable_image' : 'sortable_image_no_caption' ?>" >
			<input type="hidden" name="<?php echo $uploaded_file_key; ?>" value="<?php echo h($this->data[$uploaded_file_key]); ?>" />

			<table>
				<tr>
					<td>
						<a name="<?php echo $target_form_key; ?>"></a>
						<?php if (is_blank($this->data[$uploaded_file_key])): ?>
							<div style="width: 200px; height: 150px; overflow: hidden;">
							<img class="resize" src="<?php echo base_url(); ?>img/no_photo.jpg" />
							</div>
						<?php else: ?>
							<div style="width: 200px; height: 150px; overflow: hidden;">

							<?php if ($this->data[$file_exists_flg]): ?>
								<img class="resize" style="display: none;" src="<?php echo $this->destination_upload_url . h($this->thumbnail_prefix . $this->data[$uploaded_file_key]); ?>" />
							<?php else: ?>
								<img class="resize" style="display: none;" src="<?php echo $this->departure_upload_url . h($this->thumbnail_prefix . $this->data[$uploaded_file_key]); ?>" />
							<?php endif; ?>

							</div>
						<?php endif; ?>
					</td>
					<?php if ($this->use_image_caption): ?>
					<td style="width: 230px; vertical-align: top;">
						<span class="label">キャプション</span><br />
						<?php echo h_br($this->data[$caption_key], TRUE,'(未入力)'); ?>
					</td>
					<?php else: ?>
					<td></td>
					<?php endif; ?>
				</tr>
			</table>

		</li>
	<?php endforeach; ?>
</ul>
</div>

<?php endif; ?>

<!-- 添付ファイルを使用する場合に表示する -->
<!-- ダウンロード用ファイルを使用する場合に表示する -->
<?php if ($this->use_doc_upload): ?>
<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="4" class="table_section">ダウンロード用ファイル</th>
	</tr>
</thead>
<tbody>
	<?php for ($i = 1; $i <= $this->max_doc_file; $i++): ?>
	<?php
		$target_form_key = "upload_doc{$i}";	//ファイルアップロードのフォーム名称のキー
		$uploaded_file_key = "after_upload_doc{$i}";	//セッションに保持するためにアップロード後のファイル名を保持するキー
		$file_exists_flg = "{$uploaded_file_key}_exists_flg";
		$caption_key = "doc{$i}_caption";	//キャプション用のキー
		$title_key = "doc{$i}_title";	//キャプション用のキー
	?>
	<tr>
		<th class="span2">
			ファイル<?php echo $i; ?>
			<input type="hidden" name="<?php echo $uploaded_file_key; ?>" value="<?php echo h($this->data[$uploaded_file_key]); ?>" />
		</th>
		<td class="span3">
			<?php if (is_blank($this->data[$uploaded_file_key])): ?>
				なし
			<?php else: ?>
				<?php if ($this->data[$file_exists_flg]): ?>
					<a href="<?php echo $this->destination_upload_url . h($this->data[$uploaded_file_key]);?>" class="btn" target="_blank"><i class="icon-file"></i> ファイル確認</a>
				<?php else: ?>
					<a href="<?php echo $this->departure_upload_url . h($this->data[$uploaded_file_key]);?>" class="btn" target="_blank"><i class="icon-file"></i> ファイル確認</a>
				<?php endif; ?>
			<?php endif; ?>
		</td>
		<td class="span4">
			<span class="label">表示用ファイル名</span><br />
			<?php echo h($this->data[$title_key]); ?>
		<td>
			<span class="label">キャプション</span><br />
			<?php echo h_br($this->data[$caption_key]); ?>
		</td>
	</tr>
	<?php endfor; ?>
</tbody>
</table>

<?php endif; ?>

<div class="form-actions">
	<input type="submit" class="btn btn-primary" value="　実行　" />
	<input type="button" class="btn" value="　戻る　" 
		onclick="$('#common_form').attr('action', '<?php echo site_url($this->common_form_action_base . 'back/'); ?>');$('#common_form').submit();" />
</div>

<?php echo form_close(); ?>