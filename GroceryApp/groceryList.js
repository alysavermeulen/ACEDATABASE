/**
 * Adds an item to the list
 * @param {string} item Name of the grocery list item to be added
 * @param {number} price Price of the grocery list item to be added
 * @param {number} quantity Quantity of the grocery list item
 */
function addItem(item, price, quantity) {
	var listID = document.querySelector("#groceryList");

	// create a <span>item name</span>
	let itemName = document.createElement("span");
	itemName.setAttribute("id", "itemName");
	itemName.innerHTML = item;

	// create a <span>item price</span>
	let itemPrice = document.createElement("span");
	itemPrice.setAttribute("id", "itemPrice");
	//format the price of the item
	let displayPrice = price.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
	itemPrice.innerHTML = `$${displayPrice}`;

	// create a <span>total price</span>
	let totalPrice = document.createElement("span");
	totalPrice.setAttribute("id", "itemPrice");
	//format the price of the item
	let displayTotal = (price * quantity)
		.toFixed(2)
		.replace(/\d(?=(\d{3})+\.)/g, "$&,");
	totalPrice.innerHTML = `$${displayTotal}`;

	//create a checkbox <input>
	//<input type="checkbox"/>
	let checkbox = document.createElement("input");
	checkbox.setAttribute("type", "checkbox");

	// create the quantity input
	//<input type="number" name = "quantity" value="1" min="0" style="width: 4em"></input>
	let quantityField = document.createElement("input");
	quantityField.setAttribute("type", "number");
	quantityField.setAttribute("name", item);
	quantityField.setAttribute("min", 0);
	quantityField.setAttribute("value", quantity);

	//add event listeners for the checkbox and the number field
	checkbox.addEventListener("change", () => {
		checkBox(checkbox, quantityField, itemName, itemPrice, totalPrice);
	});
	quantityField.addEventListener("change", () => {
		if (quantityField.value == 0) {
			checkbox.checked = true;
			checkBox(checkbox, quantityField, itemName, itemPrice, totalPrice);
		} else {
			checkbox.checked = false;
			checkBox(checkbox, quantityField, itemName, itemPrice, totalPrice);
		}
	});

	// nest the contents inside the left div
	let left_div = document.createElement("div");
	left_div.setAttribute("class", "checkboxAndName");
	left_div.appendChild(checkbox);
	left_div.appendChild(quantityField);
	left_div.appendChild(itemName);

	// nest the contents inside the right div
	let right_div = document.createElement("div");
	right_div.setAttribute("class", "prices-div");
	right_div.appendChild(itemPrice);
	right_div.appendChild(totalPrice);

	// nest the contents inside the list item
	let newListItem = document.createElement("li");
	newListItem.setAttribute("class", "list-item");
	newListItem.setAttribute("id", "item");
	newListItem.appendChild(left_div);
	newListItem.appendChild(right_div);

	//append the new list item to the end of the list (before the list total)
	let ListTotal = document.querySelector("#total");
	listID.insertBefore(newListItem, ListTotal);

	//update the total sum of the list
	recalculateListTotal();
}

function checkBox(checkbox, quantityField, itemName, itemPrice, totalPrice) {
	if (!checkbox.checked) {
		itemName.classList.remove("itemChecked");
		itemPrice.classList.remove("itemChecked");
		totalPrice.classList.remove("itemChecked");
		if (quantityField.value == 0) quantityField.value = 1;
	} else {
		itemName.classList.add("itemChecked");
		itemPrice.classList.add("itemChecked");
		totalPrice.classList.add("itemChecked");
		quantityField.value = 0;
	}
	updateRowTotal(quantityField, itemPrice, totalPrice);
}

function updateRowTotal(quantityField, itemPrice, totalPrice) {
	console.log("Changing");
	let price = Number(itemPrice.innerHTML.substring(1));
	let quantity = Number(quantityField.value);
	let newTotal = (price * quantity)
		.toFixed(2)
		.replace(/\d(?=(\d{3})+\.)/g, "$&,");
	totalPrice.innerHTML = `$${newTotal}`;
	recalculateListTotal();
}

function recalculateListTotal() {
	//set the value of newTotal to 0
	var newTotal = 0;
	var listID = document.querySelector("#groceryList");

	//go through the list and add the value of each item to the total
	for (let child of listID.children) {
		if (child.id != "total") {
			let price = Number(child.lastChild.lastChild.innerHTML.substring(1));
			newTotal += price;
		}
	}

	//reformat the new total
	newTotal = newTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
	document.querySelector("#totalPrice").innerHTML = `$${newTotal}`;
}
