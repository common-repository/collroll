<?php

/**
 * Outputs a colorpicker.
 *
 * @param	string	$color			Hexadecimal color code
 * @param	int		$index			Identification number for a specific colorpicker
 */
function collroll_colorpicker( $color, $index )
{
?>
			<!-- BEGIN COLORPICKER -->		
				<table>
					<tr>
						<td valign="top">
							<div id="cp<?php echo $index; ?>_ColorMap"></div>
						</td>
						<td valign="top">
							<div id="cp<?php echo $index; ?>_ColorBar"></div>
						</td>
			
						<td valign="top">
			
							<table>
								<tr>
									<td colspan="3">
										<div id="cp<?php echo $index; ?>_Preview" style="background-color: #fff; width: 100%; height: 60px; padding: 0; margin: -2px 0px 5px 0px; border: solid 1px #000;">
											<br />
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<input type="radio" id="cp<?php echo $index; ?>_HueRadio" name="cp<?php echo $index; ?>_Mode" value="0" />
									</td>
									<td>
										<label for="cp<?php echo $index; ?>_HueRadio">H:</label>
									</td>
									<td>
										<input type="text" id="cp<?php echo $index; ?>_Hue" value="0" style="width: 40px; height: 22px; font-size:9pt;" /> &deg;
									</td>
								</tr>
			
								<tr>
									<td>
										<input type="radio" id="cp<?php echo $index; ?>_SaturationRadio" name="cp<?php echo $index; ?>_Mode" value="1" />
									</td>
									<td>
										<label for="cp<?php echo $index; ?>_SaturationRadio">S:</label>
									</td>
									<td>
										<input type="text" id="cp<?php echo $index; ?>_Saturation" value="100" style="width: 40px; height: 22px; font-size:9pt;" /> %
									</td>
								</tr>
			
								<tr>
									<td>
										<input type="radio" id="cp<?php echo $index; ?>_BrightnessRadio" name="cp<?php echo $index; ?>_Mode" value="2" />
									</td>
									<td>
										<label for="cp<?php echo $index; ?>_BrightnessRadio">B:</label>
									</td>
									<td>
										<input type="text" id="cp<?php echo $index; ?>_Brightness" value="100" style="width: 40px; height: 22px; font-size:9pt;" /> %
									</td>
								</tr>
			
								<tr>
									<td colspan="3" height="5">
			
									</td>
								</tr>
			
								<tr>
									<td>
										<input type="radio" id="cp<?php echo $index; ?>_RedRadio" name="cp<?php echo $index; ?>_Mode" value="r" />
									</td>
									<td>
										<label for="cp<?php echo $index; ?>_RedRadio">R:</label>
									</td>
									<td>
										<input type="text" id="cp<?php echo $index; ?>_Red" value="255" style="width: 40px; height: 22px; font-size:9pt;" />
									</td>
								</tr>
			
								<tr>
									<td>
										<input type="radio" id="cp<?php echo $index; ?>_GreenRadio" name="cp<?php echo $index; ?>_Mode" value="g" />
									</td>
									<td>
										<label for="cp<?php echo $index; ?>_GreenRadio">G:</label>
									</td>
									<td>
										<input type="text" id="cp<?php echo $index; ?>_Green" value="0" style="width: 40px; height: 22px; font-size:9pt;" />
									</td>
								</tr>
			
								<tr>
									<td>
										<input type="radio" id="cp<?php echo $index; ?>_BlueRadio" name="cp<?php echo $index; ?>_Mode" value="b" />
									</td>
									<td>
										<label for="cp<?php echo $index; ?>_BlueRadio">B:</label>
									</td>
									<td>
										<input type="text" id="cp<?php echo $index; ?>_Blue" value="0" style="width: 40px; height: 22px; font-size:9pt;" />
									</td>
								</tr>
			
			
								<tr>
									<td>
										#:
									</td>
									<td colspan="2">
										<input type="text" id="cp<?php echo $index; ?>_Hex" value="FF0000" style="width: 60px; height: 23px;" />
									</td>
								</tr>
			
							</table>
						</td>
					</tr>
				</table>
			
			
				<script type="text/javascript">				
				cp<?php echo $index; ?> = new Refresh.Web.ColorPicker(
					'cp<?php echo $index; ?>',
					{
						startHex: '<?php echo $color; ?>', 
						startMode:'h', 
						clientFilesPath:'<?php echo COLLROLL_URLPATH; ?>colorpicker/images/'
					});

				</script>
			<!-- END COLORPICKER -->

<?php
}
?>