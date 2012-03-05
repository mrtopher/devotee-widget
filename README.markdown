# devot:ee Widget for dashEE

If you use the [dashEE ExpressionEngine module](https://github.com/mrtopher/dashEE) and sell add-ons using [devot:ee](http://devot-ee.com) then this widget is for you. This widget displays a summary of all the sales you've made through devot:ee within the last 30 days displaying the add-ons name, date of sale and price paid.

## Installation

1.  Place the wgt.devotee.php file in the widgets folder of the dashEE module in your /system/expressionengine/third_party folder.

2.  Update the dashEE language file located in the language/eng directory of the module by adding the following two lines:
`'wgt_devotee_name' => 'devot:ee Sales',`
`'wgt_devotee_description' => 'Display your devot:ee sales for the past 30 days.',`

That's it. When you click the Widgets button from the dashboard you should now see the widget listed as an option.