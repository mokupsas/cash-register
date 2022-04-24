<html>
	<script>
		// One currency unit value
		const unitValue = [
			["PENNY", 0.01],
			["NICKEL", 0.05],
			["DIME", 0.1],
			["QUARTER", 0.25],
			["ONE", 1],
			["FIVE", 5],
			["TEN", 10],
			["TWENTY", 20],
			["ONE HUNDRED", 100]
		];
		
		
		/**
		 * Gets array key by first value coincidence
		 * @param str	Encoded ROT13 cipher.
		 * @return change 	Array key.
		 */
		function checkCashRegister(price, cash, cid) {
			let change = [];
			var status;
			var totalCash = totalInDrawer(cid);
			
			console.log(cash - price);
			console.log(totalCash);
			
			if(cash - price < totalCash)
			{
				change = formChange(price, cash, cid);
				status = "OPEN";
			}
			else if(cash - price == totalCash)
			{
				change = formChange(price, cash, cid);
				status = "CLOSED";
			}
			else
			{
				status = "INSUFFICIENT_FUNDS";
			}
			
			//return change;
			//return totalCash;
			return jsonData(status, change);
		}

		/**
		 * Count how much cash in total drawer has
		 * @param cid 	Array with cash in drawer.
		 * @return int 	Cash in total.
		 */
		function totalInDrawer(cid)
		{
			var total = 0;
			
			// Penny
			total += cid[0][1];
			
			// Nickle
			total += cid[1][1];
			
			// Dime
			total += cid[2][1];
			
			// Quarter
			total += cid[3][1];
			
			// Dollar
			total += cid[4][1];
			
			// Five Dollars
			total += cid[5][1];
			
			// Ten Dollars
			total += cid[6][1];
			
			// Twenty Dollars
			total += cid[7][1];
			
			// One-hunder Dollars
			total += cid[8][1];
			
			return Math.round(total * 100) / 100;
		}

		/**
		 * Forms change array
		 * @param change 	Change ammount.
		 * @param cid 		Array with cash in drawer.
		 * @return cid 	Array with cash in drawer left.
		 */
		function formChange(price, cash, cid)
		{
			var change = Math.abs(price - cash); // total change int
			var changeArr = []; // change by available units in drawer
			
			console.log(cid);
			console.log("Change: " + change);
			console.log("-----");
			
			for(var i=cid.length - 1; i>=0; i--)
			{
				// Find highest value to return in drawer
				//if(change >= unitValue[i][1] && cid[i][1] > 0)
				if(change >= unitValue[i][1])
				{
					console.log(
						unitValue[i][1] 
						+" (unit) = "+ 
						cid[i][1]
						+" (value)  = "+ 
						countUnits(change, unitValue[i][1])
					);
					
					// Current currency unit change
					var unitChange = countUnits(change, unitValue[i][1]);
					
					if(unitChange * unitValue[i][1] <= cid[i][1])
					{
						changeArr = addChangeToArray(unitValue[i][0], unitChange * unitValue[i][1], changeArr);
						change -= unitChange * unitValue[i][1];
					}
					else
					{
						changeArr = addChangeToArray(unitValue[i][0], cid[i][1], changeArr);
						change -= cid[i][1];	
					}
				}
				
				/* if(change == 0)
					break; */
			}
			
			console.log("-----");
			return changeArr;
		}
		
		function addChangeToArray(unit, change, array)
		{
/* 			if(array.length == 0)
			{
				array.push([unit, change]);
				return array;
			}
			
			for(var i=0; i < array.length; i++)
			{
				
			} */
			
			array.push([unit, change]);
			return array;
		}

		/**
		 * Counts how many currency units can be changed
		 * @param change 	Total ammount of change.
		 * @param uVal 		One currency unit value to count.
		 * @return int 	Ammount of units can be changed.
		 */
		function countUnits(change, uVal)
		{
			return Math.floor(change / uVal);
		}		

		/**
		 * Creates JSON from provided data
		 * @param status 	Drawer status.
		 * @param change 	Change array.
		 * @return json 	JSON object.
		 */
		function jsonData(status, change) {
			var json = JSON.parse('{ "status": "", "change": ""}');
			
			// Adding data to JSON
			json.status = status;
			json.change = change;
			
			// Returning JSON object
			return json;
		}

		console.log(
			checkCashRegister(19.5, 20, [["PENNY", 0.01], ["NICKEL", 0], ["DIME", 0], ["QUARTER", 0], ["ONE", 1], ["FIVE", 0], ["TEN", 0], ["TWENTY", 0], ["ONE HUNDRED", 0]])
		);

	</script>
</html>