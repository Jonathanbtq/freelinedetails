<?php
/* Copyright (C) 2023		Laurent Destailleur			<eldy@users.sourceforge.net>
 * Copyright (C) 2024		SuperAdmin
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * \file    freelinedetails/class/actions_freelinedetails.class.php
 * \ingroup freelinedetails
 * \brief   Example hook overload.
 *
 * TODO: Write detailed description here.
 */

require_once DOL_DOCUMENT_ROOT.'/core/class/commonhookactions.class.php';

/**
 * Class ActionsFreelinedetails
 */
class ActionsFreelinedetails extends CommonHookActions
{
	/**
	 * @var DoliDB Database handler.
	 */
	public $db;

	/**
	 * @var string Error code (or message)
	 */
	public $error = '';

	/**
	 * @var string[] Errors
	 */
	public $errors = array();


	/**
	 * @var mixed[] Hook results. Propagated to $hookmanager->resArray for later reuse
	 */
	public $results = array();

	/**
	 * @var ?string String displayed by executeHook() immediately after return
	 */
	public $resprints;

	/**
	 * @var int		Priority of hook (50 is used if value is not defined)
	 */
	public $priority;


	/**
	 * Constructor
	 *
	 *  @param	DoliDB	$db      Database handler
	 */
	public function __construct($db)
	{
		$this->db = $db;
	}


	/**
	 * Execute action
	 *
	 * @param	array<string,mixed>	$parameters	Array of parameters
	 * @param	CommonObject		$object		The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param	string				$action		'add', 'update', 'view'
	 * @return	int								Return integer <0 if KO,
	 *                           				=0 if OK but we want to process standard actions too,
	 *											>0 if OK and we want to replace standard actions.
	 */
	public function getNomUrl($parameters, &$object, &$action)
	{
		global $db, $langs, $conf, $user;
		$this->resprints = '';
		return 0;
	}

	/**
	 * Overload the doActions function : replacing the parent's function with the one below
	 *
	 * @param	array<string,mixed>	$parameters		Hook metadata (context, etc...)
	 * @param	CommonObject		$object			The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param	?string				$action			Current action (if set). Generally create or edit or null
	 * @param	HookManager			$hookmanager	Hook manager propagated to allow calling another hook
	 * @return	int									Return integer < 0 on error, 0 on success, 1 to replace standard code
	 */
	public function doActions($parameters, &$object, &$action, $hookmanager)
	{
		global $conf, $user, $langs;

		$error = 0; // Error counter

		/* print_r($parameters); print_r($object); echo "action: " . $action; */
		// @phan-suppress-next-line PhanPluginEmptyStatementIf
		if (in_array($parameters['currentcontext'], array('somecontext1', 'somecontext2'))) {	    // do something only for the context 'somecontext1' or 'somecontext2'
			// Do what you want here...
			// You can for example load and use call global vars like $fieldstosearchall to overwrite them, or update the database depending on $action and GETPOST values.
		}

		if (!$error) {
			$this->results = array('myreturn' => 999);
			$this->resprints = 'A text to show';
			return 0; // or return 1 to replace standard code
		} else {
			$this->errors[] = 'Error message';
			return -1;
		}
	}


	/**
	 * Overload the doMassActions function : replacing the parent's function with the one below
	 *
	 * @param	array<string,mixed>	$parameters		Hook metadata (context, etc...)
	 * @param	CommonObject		$object			The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param	?string				$action			Current action (if set). Generally create or edit or null
	 * @param	HookManager			$hookmanager	Hook manager propagated to allow calling another hook
	 * @return	int									Return integer < 0 on error, 0 on success, 1 to replace standard code
	 */
	public function doMassActions($parameters, &$object, &$action, $hookmanager)
	{
		global $conf, $user, $langs;

		$error = 0; // Error counter

		/* print_r($parameters); print_r($object); echo "action: " . $action; */
		if (in_array($parameters['currentcontext'], array('somecontext1', 'somecontext2'))) {		// do something only for the context 'somecontext1' or 'somecontext2'
			// @phan-suppress-next-line PhanPluginEmptyStatementForeachLoop
			foreach ($parameters['toselect'] as $objectid) {
				// Do action on each object id
			}
		}

		if (!$error) {
			$this->results = array('myreturn' => 999);
			$this->resprints = 'A text to show';
			return 0; // or return 1 to replace standard code
		} else {
			$this->errors[] = 'Error message';
			return -1;
		}
	}


	/**
	 * Overload the addMoreMassActions function : replacing the parent's function with the one below
	 *
	 * @param	array<string,mixed>	$parameters     Hook metadata (context, etc...)
	 * @param	CommonObject		$object         The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param	?string	$action						Current action (if set). Generally create or edit or null
	 * @param	HookManager	$hookmanager			Hook manager propagated to allow calling another hook
	 * @return	int									Return integer < 0 on error, 0 on success, 1 to replace standard code
	 */
	public function addMoreMassActions($parameters, &$object, &$action, $hookmanager)
	{
		global $conf, $user, $langs;

		$error = 0; // Error counter
		$disabled = 1;

		/* print_r($parameters); print_r($object); echo "action: " . $action; */
		if (in_array($parameters['currentcontext'], array('somecontext1', 'somecontext2'))) {		// do something only for the context 'somecontext1' or 'somecontext2'
			$this->resprints = '<option value="0"'.($disabled ? ' disabled="disabled"' : '').'>'.$langs->trans("FreelinedetailsMassAction").'</option>';
		}

		if (!$error) {
			return 0; // or return 1 to replace standard code
		} else {
			$this->errors[] = 'Error message';
			return -1;
		}
	}



	/**
	 * Execute action before PDF (document) creation
	 *
	 * @param	array<string,mixed>	$parameters	Array of parameters
	 * @param	CommonObject		$object		Object output on PDF
	 * @param	string				$action		'add', 'update', 'view'
	 * @return	int								Return integer <0 if KO,
	 *											=0 if OK but we want to process standard actions too,
	 *											>0 if OK and we want to replace standard actions.
	 */
	public function formObjectOptions($parameters, &$object, &$action)
	{
		global $conf, $user, $langs, $hookmanager;

		$langs->load('freelinedetails@freelinedetails');
		/* print_r($parameters); print_r($object); echo "action: " . $action; */
		// @phan-suppress-next-line PhanPluginEmptyStatementIf
		if (in_array($parameters['currentcontext'], array('ordercard', 'propalcard'))) {
			if(!empty($object->lines)) {
				?><script type="text/javascript">
					function freeline2product(lineid) {
						
						// Récupération de la ligne produit libre
						$a = $('a[lineid='+lineid+']');
						let label = $a.attr('label');
						let qty = $a.attr('qty');
						let ref = '';
						let description = '';
						<?php
						if ($conf->global->FREELINEDETAILS_MORECHOICE) {
							?>
							let weight = '';
							let cost_price = '';
							<?php
						}
						?>
						<?php
						if ($conf->global->FREELINEDETAILS_MORECHOICE) {
							?>
							let length = '';
							let width = '';
							let height = '';
							<?php
						}
						?>
						let price = $a.attr('price');
						let product_type = $a.attr('product_type');
						let tva = $a.attr('tva');

						const newDiv = document.createElement('div');
						newDiv.className = 'freelinedetails_list_freeproduct'
						let htmlContent = `
						<div class="freedtl_btn_header">
						<h3><?php echo $langs->trans("FREELINEDETAILS_CREATE_PRODUCT"); ?></h3><button id="closeBtn">X</button></div>
						<div>
						<label><?php echo $langs->trans("FREELINEDETAILS_CREATE_PRODUCT_NAME"); ?></label><input type="text" id="label" value="${label}"></div>
						<div>
						<label><?php echo $langs->trans("FREELINEDETAILS_CREATE_PRODUCT_REF"); ?></label><input type="text" id="ref" value="${ref}"></div>
						<div>
						<label><?php echo $langs->trans("FREELINEDETAILS_CREATE_PRODUCT_DESC"); ?></label><textarea id="description" name="description" rows="1" placeholder="Entrez une description..." >${description}</textarea></div>`;
						<?php if ($conf->global->FREELINEDETAILS_MORECHOICE) { ?>
						htmlContent += `
							<h2><?php echo $langs->trans("FREELINEDETAILS_CREATE_PRODUCT_MOREDTL"); ?></h2>
							<section class="freelinedetails_moreoptions">
							<div>
							<label><?php echo $langs->trans("FREELINEDETAILS_CREATE_PRODUCT_WEIGHT"); ?></label><input type="text" id="weight" value="${weight}"></div>
							<div>
							<label><?php echo $langs->trans("FREELINEDETAILS_CREATE_PRODUCT_COUTFABRICATION"); ?></label><input type="text" id="cost_price" value="${cost_price}"></div>`;
						<?php } ?>
						<?php if ($conf->global->FREELINEDETAILS_MORECHOICE_SIZE) { ?>
						htmlContent += `
							<h2 class="freelinedetails_moredtl_h2"><?php echo $langs->trans("FREELINEDETAILS_CREATE_PRODUCT_MORESIZE"); ?></h2>
							<section class="freelinedetails_moreoptions_size">
							<div>
							<label><?php echo $langs->trans("FREELINEDETAILS_CREATE_PRODUCT_LONG"); ?></label><input type="text" id="weight" value="${length}"></div>
							<div>
							<label><?php echo $langs->trans("FREELINEDETAILS_CREATE_PRODUCT_HAUT"); ?></label><input type="text" id="height" value="${height}"></div>
							<div>
							<label><?php echo $langs->trans("FREELINEDETAILS_CREATE_PRODUCT_LARG"); ?></label><input type="text" id="cost_price" value="${width}"></div>
							</section>`;
						<?php } ?>
						htmlContent += `
							<div>
							<label><?php echo $langs->trans("FREELINEDETAILS_CREATE_PRODUCT_PRICE"); ?></label><input type="number" id="price" value="${price}" step="0.01"></div>
							<div>
							<label><?php echo $langs->trans("FREELINEDETAILS_CREATE_PRODUCT_TYPE"); ?></label><input type="text" id="product_type" value="${product_type}"></div>
							<div>
							<label>Tva</label><input type="number" id="tva" value="${tva}" step="0.01"></div>
							<div>
							<button id="saveBtn" class="freelinedetails_savebtn">Enregistrer</button></div>
						`;

						document.body.addEventListener('click', (event) => {
							if (event.target.matches('.freelinedetails_list_freeproduct freelinedetails_moredtl_h2')) {
								const divMoredetails = document.querySelector('.freelinedetails_moreoptions_size');
								if (divMoredetails) {
									divMoredetails.style.display = divMoredetails.style.display === 'none' ? 'flex' : 'none';
								} else {
									console.error('Élément .freelinedetails_moreoptions_size introuvable');
								}
							}
						});


						// Insérer le contenu dans le div
						newDiv.innerHTML = htmlContent;
						document.body.appendChild(newDiv);

						document.getElementById('closeBtn').addEventListener('click', function() {
							document.body.removeChild(newDiv);
						});
						
						// Gestion du bouton "Enregistrer" pour récupérer les nouvelles valeurs
						document.getElementById('saveBtn').addEventListener('click', function() {
							// Récupérer les nouvelles valeurs saisies par l'utilisateur
							const newLabel = document.getElementById('label').value;
							const newRef = document.getElementById('ref').value;
							const newDescription = document.getElementById('description').value;
							<?php
							if ($conf->global->FREELINEDETAILS_MORECHOICE === '1') {
								?>
								const newWeight = document.getElementById('weight').value;
								const newCost_price = document.getElementById('cost_price').value;
								<?php
							}
							?>
							<?php
							if ($conf->global->FREELINEDETAILS_MORECHOICE_SIZE === '1') {
								?>
								const newLength = document.getElementById('length').value;
								const newWidth = document.getElementById('width').value;
								const newHeight = document.getElementById('height').value;
								<?php
							}
							?>
							const newPrice = document.getElementById('price').value;
							const newProductType = document.getElementById('product_type').value;
							const newTva = document.getElementById('tva').value;

							const dataToSend = {
    							lineid,
								label: newLabel,
								ref: newRef,
								description: newDescription,
								price: newPrice,
								product_type: newProductType,
								tva: newTva,
								element: "<?php echo $object->element; ?>"
							};
							<?php if ($conf->global->FREELINEDETAILS_MORECHOICE === '1'): ?>
							dataToSend.weight = newWeight;
							dataToSend.cost_price = newCost_price;
							<?php endif; ?>
							<?php if ($conf->global->FREELINEDETAILS_MORECHOICE_SIZE === '1'): ?>
							dataToSend.length = newLength;
							dataToSend.width = newWidth;
							dataToSend.height = newHeight;
							<?php endif; ?>

							$.ajax({
								url: "<?php echo dol_buildpath('/freelinedetails/script/savefreeline.php',1) ?>",
								type: 'POST',
								data: dataToSend,
								success: function(response) {
									document.body.removeChild(newDiv);
									// document.location.reload();
								},
								error: function() {
									alert('Erreur lors de l\'enregistrement');
								}
							})
						});
					}
					$(document).ready(function () {<?php
						global $addButtonToConvertAll;
						$addButtonToConvertAll = false;
						foreach($object->lines as &$line) {
							if($line->product_type <= 1 && $line->fk_product == 0) { // Ceci est une ligne libre
								$addButtonToConvertAll=true;
								$lineid = !empty($line->id) ? $line->id : $line->rowid; // compatibilité 3.6
								$desc = !empty($line->desc) ? $line->desc : $line->description;
								$desc = strip_tags($desc);
								$link = '<a href="javascript:;" style="float:left;"';
								$link .= ' onclick="freeline2product('.$lineid.')" lineid="'.$lineid.'"';
								$link .= ' label="'.htmlentities(addslashes(strtr($desc, array("\n" => '\n', "\r" => '')))).'"';
								$link .= ' qty="'.$line->qty.'" price="'.$line->subprice.'"';
								$link .= ' product_type="'.$line->product_type.'" tva="'.$line->tva_tx.'"';
								$link .= ' weight="'.($line->weight ?? '').'"';
								$link .= ' height="'.($line->height ?? '').'"';
								$link .= ' cost_price="'.($line->cost_price ?? '').'"';
								$link .= ' length="'.($line->length ?? '').'"';
								$link .= ' width="'.($line->width ?? '').'">';
								$link .= img_left($langs->trans('MakeAsProduct')).'</a>';
								?>
								$('tr#row-<?php echo $lineid; ?> td:first').append('<?php echo $link; ?>');
								<?php
							}
							
						}
					?>
				});
				</script>
				<?php
			}
		}

		return 0;
	}

	/**
	 * Execute action after PDF (document) creation
	 *
	 * @param	array<string,mixed>	$parameters	Array of parameters
	 * @param	CommonDocGenerator	$pdfhandler	PDF builder handler
	 * @param	string				$action		'add', 'update', 'view'
	 * @return	int								Return integer <0 if KO,
	 * 											=0 if OK but we want to process standard actions too,
	 *											>0 if OK and we want to replace standard actions.
	 */
	public function afterPDFCreation($parameters, &$pdfhandler, &$action)
	{
		global $conf, $user, $langs;
		global $hookmanager;

		$outputlangs = $langs;

		$ret = 0;
		$deltemp = array();
		dol_syslog(get_class($this).'::executeHooks action='.$action);

		/* print_r($parameters); print_r($object); echo "action: " . $action; */
		// @phan-suppress-next-line PhanPluginEmptyStatementIf
		if (in_array($parameters['currentcontext'], array('somecontext1', 'somecontext2'))) {
			// do something only for the context 'somecontext1' or 'somecontext2'
		}

		return $ret;
	}



	/**
	 * Overload the loadDataForCustomReports function : returns data to complete the customreport tool
	 *
	 * @param	array<string,mixed>	$parameters		Hook metadata (context, etc...)
	 * @param	?string				$action 		Current action (if set). Generally create or edit or null
	 * @param	HookManager			$hookmanager    Hook manager propagated to allow calling another hook
	 * @return	int									Return integer < 0 on error, 0 on success, 1 to replace standard code
	 */
	public function loadDataForCustomReports($parameters, &$action, $hookmanager)
	{
		global $langs;

		$langs->load("freelinedetails@freelinedetails");

		$this->results = array();

		$head = array();
		$h = 0;

		if ($parameters['tabfamily'] == 'freelinedetails') {
			$head[$h][0] = dol_buildpath('/module/index.php', 1);
			$head[$h][1] = $langs->trans("Home");
			$head[$h][2] = 'home';
			$h++;

			$this->results['title'] = $langs->trans("Freelinedetails");
			$this->results['picto'] = 'freelinedetails@freelinedetails';
		}

		$head[$h][0] = 'customreports.php?objecttype='.$parameters['objecttype'].(empty($parameters['tabfamily']) ? '' : '&tabfamily='.$parameters['tabfamily']);
		$head[$h][1] = $langs->trans("CustomReports");
		$head[$h][2] = 'customreports';

		$this->results['head'] = $head;

		$arrayoftypes = array();
		//$arrayoftypes['freelinedetails_myobject'] = array('label' => 'MyObject', 'picto'=>'myobject@freelinedetails', 'ObjectClassName' => 'MyObject', 'enabled' => isModEnabled('freelinedetails'), 'ClassPath' => "/freelinedetails/class/myobject.class.php", 'langs'=>'freelinedetails@freelinedetails')

		$this->results['arrayoftype'] = $arrayoftypes;

		return 0;
	}



	/**
	 * Overload the restrictedArea function : check permission on an object
	 *
	 * @param	array<string,mixed>	$parameters		Hook metadata (context, etc...)
	 * @param	string				$action			Current action (if set). Generally create or edit or null
	 * @param	HookManager			$hookmanager	Hook manager propagated to allow calling another hook
	 * @return	int									Return integer <0 if KO,
	 *												=0 if OK but we want to process standard actions too,
	 *												>0 if OK and we want to replace standard actions.
	 */
	public function restrictedArea($parameters, &$action, $hookmanager)
	{
		global $user;

		if ($parameters['features'] == 'myobject') {
			if ($user->hasRight('freelinedetails', 'myobject', 'read')) {
				$this->results['result'] = 1;
				return 1;
			} else {
				$this->results['result'] = 0;
				return 1;
			}
		}

		return 0;
	}

	/**
	 * Execute action completeTabsHead
	 *
	 * @param	array<string,mixed>	$parameters		Array of parameters
	 * @param	CommonObject		$object			The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param	string				$action			'add', 'update', 'view'
	 * @param	Hookmanager			$hookmanager	Hookmanager
	 * @return	int									Return integer <0 if KO,
	 *												=0 if OK but we want to process standard actions too,
	 *												>0 if OK and we want to replace standard actions.
	 */
	public function completeTabsHead(&$parameters, &$object, &$action, $hookmanager)
	{
		global $langs, $conf, $user;

		if (!isset($parameters['object']->element)) {
			return 0;
		}
		if ($parameters['mode'] == 'remove') {
			// used to make some tabs removed
			return 0;
		} elseif ($parameters['mode'] == 'add') {
			$langs->load('freelinedetails@freelinedetails');
			// used when we want to add some tabs
			$counter = count($parameters['head']);
			$element = $parameters['object']->element;
			$id = $parameters['object']->id;
			// verifier le type d'onglet comme member_stats où ça ne doit pas apparaitre
			// if (in_array($element, ['societe', 'member', 'contrat', 'fichinter', 'project', 'propal', 'commande', 'facture', 'order_supplier', 'invoice_supplier'])) {
			if (in_array($element, ['context1', 'context2'])) {
				$datacount = 0;

				$parameters['head'][$counter][0] = dol_buildpath('/freelinedetails/freelinedetails_tab.php', 1) . '?id=' . $id . '&amp;module='.$element;
				$parameters['head'][$counter][1] = $langs->trans('FreelinedetailsTab');
				if ($datacount > 0) {
					$parameters['head'][$counter][1] .= '<span class="badge marginleftonlyshort">' . $datacount . '</span>';
				}
				$parameters['head'][$counter][2] = 'freelinedetailsemails';
				$counter++;
			}
			if ($counter > 0 && (int) DOL_VERSION < 14) {  // @phpstan-ignore-line
				$this->results = $parameters['head'];
				// return 1 to replace standard code
				return 1;
			} else {
				// From V14 onwards, $parameters['head'] is modifiable by reference
				return 0;
			}
		} else {
			// Bad value for $parameters['mode']
			return -1;
		}
	}

	/* Add other hook methods here... */
}
