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
			let change = [];						// 2D array with change units
			var status;								// drawer status that will be returned with change	
			var totalCash;					 		// total cash in drawer (int)
			var totalChange = cash - price;			// total change to give (int)
			
			//console.log(cid);
			console.log("Change: " + totalChange);
			console.log("-----");
			for(var i=cid.length - 1; i>=0; i--)
			{
				// Find highest value to return in drawer
				//if(change >= unitValue[i][1] && cid[i][1] > 0)
				if(totalChange >= unitValue[i][1])
				{
					// Takes as many current currency units as available
					var drawerTake = countUnits(totalChange, cid[i][1], unitValue[i][1]); 
					
					console.log(
						unitValue[i][1] 
						+" (unit) = "+ 
						cid[i][1]
						+" (value)  = "+ 
						drawerTake
						+" (times)  = "+ 
						unitValue[i][1] * drawerTake
						+" (substract)  = "+
						parseFloat(unitValue[i][1] * drawerTake).toPrecision(3)
					);
					
					// Adds current change units to 2D array
					change = addChangeToArray(unitValue[i][0], unitValue[i][1] * drawerTake, change);
					
					// Substract current currency unit given ammount from total change
					//totalChange -= unitValue[i][1] * drawerTake;
					//totalChange = parseFloat(totalChange).toPrecision(2);
					totalChange = parseFloat(totalChange- (unitValue[i][1] * drawerTake)).toPrecision(4);
					
					// Stop loop if all change has been given
					if(change == 0)
						break;
				}
			}
			console.log("-----");
			
			totalCash = totalInDrawer(cid);
			console.log(totalChange);
			console.log(totalCash);
			
			// Managing return status
			if(totalChange == 0 && totalCash > cash - price)
			{
				status = "OPEN";
			}
			else if(totalChange == 0 && totalCash == cash - price)
			{
				status = "CLOSED";
			}
			else 
			{
				change = [];
				status = "INSUFFICIENT_FUNDS";
			}
			
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
		
		function addChangeToArray(unit, change, array)
		{
			array.push([unit, change]);
			return array;
		}

		/**
		 * Counts how many currency units can be changed
		 * @param change 	Total ammount of change.
		 * @param units 	How many units drawer has.
		 * @param uVal 		One currency unit value to count.
		 * @return int 		Ammount of units can be changed.
		 */
		function countUnits(change, units, uVal)
		{
			if(change <= units)
			{
				return Math.floor(change / uVal);
			}
			return Math.floor(units / uVal);;
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
			checkCashRegister(19.5, 20, [["PENNY", 0.5], ["NICKEL", 0], ["DIME", 0], ["QUARTER", 0], ["ONE", 0], ["FIVE", 0], ["TEN", 0], ["TWENTY", 0], ["ONE HUNDRED", 0]])
		);

	</script>
</html>