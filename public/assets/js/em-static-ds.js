/**
 * @extends storeLocator.StaticDataFeed
 * @constructor
 */
function EMDataSource() {
  $.extend(this, new storeLocator.StaticDataFeed);

  var that = this;
  $.get('/storage/app/public/em.csv', function(data) {
    that.setStores(that.parse_(data));
  });
}

/**
 * @const
 * @type {!storeLocator.FeatureSet}
 * @private
 */
EMDataSource.prototype.FEATURES_ = new storeLocator.FeatureSet(
  new storeLocator.Feature('Plumbing-YES', 'Plumbing Supplies'),
  new storeLocator.Feature('Electrical-YES', 'Electrical Supplies'),
  new storeLocator.Feature('Builders-YES', 'Builders Supplies'),
  new storeLocator.Feature('Hire-YES', 'Hire Shop'),
  new storeLocator.Feature('Decorating-YES', 'Painting & Decorating'),
  new storeLocator.Feature('Flooring-YES', 'Flooring Suppliers'),
  // new storeLocator.Feature('Auto-YES', 'Auto Parts'),
  new storeLocator.Feature('Aggregate-YES', 'Aggregate Suppliers'),
  new storeLocator.Feature('Roofing-YES', 'Roofing Suppliers'),
  new storeLocator.Feature('Fixings-YES', 'Fixings & Fasteners'),
  new storeLocator.Feature('Ironmongery-YES', 'Ironmongery & Hardware'),
  // new storeLocator.Feature('Tyres-YES', 'Tyres'),
  new storeLocator.Feature('Health-YES', 'Health & Safety Suppliers'),
);

/**
 * @return {!storeLocator.FeatureSet}
 */
EMDataSource.prototype.getFeatures = function() {
  return this.FEATURES_;
};

/**
 * @private
 * @param {string} csv
 * @return {!Array.<!storeLocator.Store>}
 */
EMDataSource.prototype.parse_ = function(csv) {
  var stores = [];
  var rows = csv.split('\n');
  var headings = this.parseRow_(rows[0]);

  for (var i = 1, row; row = rows[i]; i++) {
    row = this.toObject_(headings, this.parseRow_(row));
    var features = new storeLocator.FeatureSet;
    features.add(this.FEATURES_.getById('Plumbing-' + row.Plumbing));
    features.add(this.FEATURES_.getById('Electrical-' + row.Electrical));
    features.add(this.FEATURES_.getById('Builders-' + row.Builders));
    features.add(this.FEATURES_.getById('Hire-' + row.Hire));
    features.add(this.FEATURES_.getById('Decorating-' + row.Decorating));
    features.add(this.FEATURES_.getById('Flooring-' + row.Flooring));
    // features.add(this.FEATURES_.getById('Auto-' + row.Auto));
    features.add(this.FEATURES_.getById('Aggregate-' + row.Aggregate));
    features.add(this.FEATURES_.getById('Roofing-' + row.Roofing));
    features.add(this.FEATURES_.getById('Fixings-' + row.Fixings));
    features.add(this.FEATURES_.getById('Ironmongery-' + row.Ironmongery));
    // features.add(this.FEATURES_.getById('Tyres-' + row.Tyres));
    features.add(this.FEATURES_.getById('Health-' + row.Health));


    var position = new google.maps.LatLng(row.Ycoord, row.Xcoord);
    var merchID = this.join_(['<strong>Merchant ID</strong>: ', row.Merchant_id], '');
    var shop = this.join_([row.Shp_num_an, row.Shp_centre]);
  	//var web = this.join_([row.Web_address], ', ');
  	//var web = this.join_([row.Web_address], ', ');
    var locality = this.join_([row.Locality, row.Postcode]);
    var links = this.join_(['<a class="callnow" href="tel:',row.Telephone,'">Call Now</a><a class="createpo" href="po-create/?id=',row.uuid,'">Create P/O</a><div class="clearfix></div>"'], '');

    // var websiteT = this.join_([row.Web_address], ', ');


	//var webCol = "";
	//if (row.Web_address() !== "") {
	//	webCol = this.join_([row.Web_address], ', ');
	//}
    var weba = "";

	if(row.Web_address == "<a href='' target='_blank'>Visit Website Now</a>"){

		} else {
		  weba = row.Web_address;
		}

    var store = new storeLocator.Store(row.uuid, position, features, {
		title: row.Fcilty_nam,
		address: this.join_([merchID, shop, row.Street_add, locality, row.Country, row.Telephone, weba], '<br />'),
		web: this.join_([links], '')
    });
    stores.push(store);
  }
  return stores;
};

/**
 * Joins elements of an array that are non-empty and non-null.
 * @private
 * @param {!Array} arr array of elements to join.
 * @param {string} sep the separator.
 * @return {string}
 */
EMDataSource.prototype.join_ = function(arr, sep) {
  var parts = [];
  for (var i = 0, ii = arr.length; i < ii; i++) {
    arr[i] && parts.push(arr[i]);
  }
  return parts.join(sep);
};

/**
 * Very rudimentary CSV parsing - we know how this particular CSV is formatted.
 * IMPORTANT: Don't use this for general CSV parsing!
 * @private
 * @param {string} row
 * @return {Array.<string>}
 */
EMDataSource.prototype.parseRow_ = function(row) {
  // Strip leading quote.
  if (row.charAt(0) == '"') {
    row = row.substring(1);
  }
  // Strip trailing quote. There seems to be a character between the last quote
  // and the line ending, hence 2 instead of 1.
  if (row.charAt(row.length - 2) == '"') {
    row = row.substring(0, row.length - 2);
  }

  row = row.split('","');

  return row;
};

/**
 * Creates an object mapping headings to row elements.
 * @private
 * @param {Array.<string>} headings
 * @param {Array.<string>} row
 * @return {Object}
 */
EMDataSource.prototype.toObject_ = function(headings, row) {
  var result = {};
  for (var i = 0, ii = row.length; i < ii; i++) {
    result[headings[i]] = row[i];
  }
  return result;
};
