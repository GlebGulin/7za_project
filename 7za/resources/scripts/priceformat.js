function formatPrice(number)
        {
            var numberStr = new String(number);
            if ( numberStr.indexOf('.') != -1 )
            {
                var intN = numberStr.substr(0, numberStr.indexOf('.'));
                var floatN = ','+numberStr.substr(numberStr.indexOf('.')+1);
                if (floatN.length == 2) floatN = floatN + '0';
            }
            else
            {
                var intN = numberStr;
                var floatN = ',00';
            }
            
            var i = intN.length;
            var int_wd = '';
            while (i > 0)
            {
                i--;
                int_wd = intN.substr(i, 1) + int_wd;
                if ((intN.length-i) % 3 == 0 && i != 0)
                    int_wd = '.' + int_wd;
            }
            return int_wd + floatN;
        }
