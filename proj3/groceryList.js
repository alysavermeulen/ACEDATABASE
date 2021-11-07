// add an event for keypress
let inputNode = document.querySelector("input[name='addItem']");
inputNode.addEventListener("keydown", function (evt) {
	// need to check if the return key was pressed
	if (evt.code === "Enter" && inputNode.value != "") {
		// get the value from the input field
		addItem("#groceryList", inputNode.value, 1.0);

		// clear out field
		inputNode.value = "";
	}
});

/**
 * Adds an item to the list
 * @param {string} listID HTML id of the list
 * @param {string} item Name of the grocery list item to be added
 * @param {number} price Price of the grocery list item to be added
 */
function addItem(listID, item, price) {
	if (!listID.startsWith("#")) {
		listID = "#" + listID;
	}

	//create a checkbox <input>
	//<input type="checkbox"/>
	let checkbox = document.createElement("input");

	checkbox.setAttribute("type", "checkbox");
	checkbox.addEventListener("change", () => {
		if (checkbox.nextSibling.classList.contains("itemChecked"))
			checkbox.nextSibling.classList.remove("itemChecked");
		else checkbox.nextSibling.classList.add("itemChecked");
	});

	// create a <span>item name</span>
	let itemName = document.createElement("span");
	itemName.setAttribute("id", "itemName");
	itemName.innerHTML = item;

	// nest the contents inside the list item
	let div = document.createElement("div");
	div.setAttribute("class", "checkboxAndName");
	div.appendChild(checkbox);
	div.appendChild(itemName);

	// create a <span>item price</span>
	let itemPrice = document.createElement("span");
	itemPrice.setAttribute("id", "itemPrice");
	//format the price of the item
	let displayPrice = price.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
	itemPrice.innerHTML = `$${displayPrice}`;

	// nest the contents inside the list item
	let newListItem = document.createElement("li");
	newListItem.setAttribute("class", "list-item");
	newListItem.setAttribute("id", "item");
	newListItem.appendChild(div);
	newListItem.appendChild(itemPrice);

	//append the new list item to the end of the list (before the list total)
	let ul = document.querySelector(listID);
	let ListTotal = document.querySelector("#total");
	console.log(ListTotal);
	ul.insertBefore(newListItem, ListTotal);
}

addItem("#groceryList", "Milk", 1.0);
addItem("#groceryList", "Eggs", 1.0);
addItem("#groceryList", "Bread", 1.0);
