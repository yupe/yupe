<table>
    <thead>
        <tr>
            <th class="al-r"><?php echo YiiDebug::t('Properties')?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr class="even">
            <th><?php echo YiiDebug::t('Assets path')?></th>
            <td><?php echo $AM->getBasePath()?></td>
        </tr><tr class="odd">
            <th><?php echo YiiDebug::t('Exclude files')?></th>
            <td><?php echo implode(',', $AM->excludeFiles)?></td>
        </tr><tr class="even">
            <th><?php echo YiiDebug::t('New dir mode')?></th>
            <td><?php echo $AM->newDirMode?></td>
        </tr><tr class="odd">
            <th><?php echo YiiDebug::t('New file mode')?></th>
            <td><?php echo $AM->newFileMode?></td>
        </tr>
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th class="al-r"><?php echo YiiDebug::t('Load assets')?></th>
            <th class="al-l"><?php echo YiiDebug::t('Path')?></th>
            <th><?php echo YiiDebug::t('Files')?></th>
            <th><?php echo YiiDebug::t('Date create')?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        
        $DF = new CDateFormatter(Yii::app()->sourceLanguage);
        $i=0;
        foreach($assets as $asset){
            $i++;

            $path = $AM->getBasePath().'/'.$asset;
            $files = CFileHelper::findFiles($path);
            $fileList = implode('<br />', $files);

			$blockAll = false;
			if(preg_match('|yii\.debug\.toolbar\.js|is', $fileList)) $blockAll = true;

            ?>
        <tr class="<?php echo $i%2?'even':'odd'?>">
            <th><?php echo $asset?></th>
            <td>
                <a title="<?php echo YiiDebug::t('Show files')?>" href="#"
				   onclick="jQuery('.details', $(this).parent('td')).toggleClass('hidden'); return false;"><?php echo $path?></a>
                <div class='details hidden'>
                    <?php echo $fileList?>
                </div>
            </td>
            <td class="al-c"><?php echo YiiDebug::t('{n} file|{n} files', array(count($files)))?></td>
            <td class="al-c"><?php echo $DF->formatDateTime(filemtime($path))?></td>
            <td class="al-c">
                <a class="deleteAsset" href="<?php echo $this->owner->assetsUrl?>/ajax.php?deleteasset=<?php echo $asset?>"
						onclick="deleteAsset(this, <?php echo $blockAll?'true':'false'?>); return false;">
										<?php echo YiiDebug::t('Clean')?></a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
	function deleteAsset(link, blockAll){
		$.getJSON(link.href, {}, function(data){
			if(data == 'ok'){
				$(link).parents('tr').remove();
				if(blockAll){
					$('a.deleteAsset').remove();
				}
			}
			if(data == 'notexists'){
				alert('<?php echo YiiDebug::t('Path not found.')?>');
			}
			if(data == 'unknow'){
				alert('<?php echo YiiDebug::t('Unknow error.')?>');
			}
		});
	}
</script>