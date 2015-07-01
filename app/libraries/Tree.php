<?php
/**
 * Class for generating nested lists
 * can be used for menu structure, categories, etc
 *
 * example:
 *
 * $tree = new Tree;
 * $tree->add_item(1, 0, '', 'Item 1');
 * $tree->add_item(2, 0, '', 'Item 2');
 * $tree->add_item(3, 1, '', 'Item 1.1');
 * $tree->add_item(4, 1, '', 'Item 1.2');
 * echo $tree->generate_list();
 *
 * output:
 * <ul>
 * 	<li>Item 1
 * 		<ul>
 * 			<li>Item 1.1</li>
 * 			<li>Item 1.2</li>
 * 		</ul>
 * 	</li>
 * 	<li>Item 2</li>
 * </ul>
 *
 * @author gawibowo
 */
class Tree {

	/**
	 * variable to store temporary data to be processed later
	 *
	 * @var array
	 */
	var $data;

	/**
	 * Add an item
	 *
	 * @param int $id 			ID of the item
	 * @param int $parent 		parent ID of the item
	 * @param string $li_attr 	attributes for <li>
	 * @param string $label		text inside <li></li>
	 */
	function add_item($id, $parent, $li_attr, $label) {
		$this->data[$parent][] = array('id' => $id, 'li_attr' => $li_attr, 'label' => $label);
	}

	/**
	 * Generates nested lists
	 *
	 * @param string $ul_attr
	 * @return string
	 */
	function generate($ul_attr = '') {
		return $this->ul(0, $ul_attr);
	}

	/**
	 * Recursive method for generating nested lists
	 *
	 * @param int $parent
	 * @param string $attr
	 * @return string
	 */
	function ul($parent = 0, $attr = '') {
		static $i = 1;
		$indent = str_repeat("\t\t", $i);
		if (isset($this->data[$parent])) {
			if ($attr) {
				$attr = ' ' . $attr;
			}
			$html = "\n$indent";
			$html .= "<ul$attr>";
			$i++;
			foreach ($this->data[$parent] as $row) {
				$child = $this->ul($row['id']);
				$html .= "\n\t$indent";
				$html .= '<li'. $row['li_attr'] . '>';
				$html .= $row['label'];
				if ($child) {
					$i--;
					$html .= $child;
					$html .= "\n\t$indent";
				}
				$html .= '</li>';
			}
			$html .= "\n$indent</ul>";
			return $html;
		} else {
			return false;
		}
	}

	/**
	 * Clear the temporary data
	 *
	 */
	function clear() {
		$this->data = array();
	}
}