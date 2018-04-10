<div id="add-rate-form" >
    <div class="row">
        <div class="col-md-4">
            <label>Currency</label>
            <select class="form-control" name="currency" placeholder="Currency">
                <option value="CAD">CAD</option>
                <option value="USD">USD</option>
                <option value="PHP">PHP</option>
            </select>
        </div>
        <div class="col-md-4">
            <label>Rate Type</label>
            <select class="form-control" name="rate_type" placeholder="Currency">
                <option value="hourly">Hourly</option>
                <option value="fixed">Fixed</option>
            </select>
        </div>
        <div class="col-md-4">
            <label>Rate</label>
            <input class="form-control" name="rate_value" value="" />
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label>Pay Period</label>
            <select class="form-control pay-period" name="pay_period" placeholder="Pay Period">
                <option value="biweekly">Biweekly</option>
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
                <option value="semi-monthly">Semi-monthly</option>
            </select>
        </div>
        <div class="col-md-6">
            <div id="payday-container">
                <div class="row">
                    <div class="col-md-6">
                        <label>First Payment</label>
                        <select id="biweekly-1-period" name="biweekly-1" class="form-control">
                            <option>Monday</option>
                            <option>Tuesday</option>
                            <option>Wednesday</option>
                            <option>Thursday</option>
                            <option>Friday</option>
                            <option>Saturday</option>
                            <option>Sunday</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Second Payment</label>
                        <select id="biweekly-2-period" name="biweekly-2" class="form-control">
                            <option>Monday</option>
                            <option>Tuesday</option>
                            <option>Wednesday</option>
                            <option>Thursday</option>
                            <option>Friday</option>
                            <option>Saturday</option>
                            <option>Sunday</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.pay-period').on('change', function () {

        var period = $(this).val();
        var dropdown;

        switch (period) {
            case 'weekly':
                dropdown = '<label>Pay Day</label><select id="weekly-period" name="weekly" class="form-control">' +
                        '<option>Monday</option>' +
                        '<option>Tuesday</option>' +
                        '<option>Wednesday</option>' +
                        '<option>Thursday</option>' +
                        '<option>Friday</option>' +
                        '<option>Saturday</option>' +
                        '<option>Sunday</option>' +
                        '</select>';
                break;
            case 'biweekly':

                dropdown = '<div class="row">' +
                        '<div class="col-md-6">' +
                        '<label>First Payment</label>' +
                        '<select id="biweekly-1-period" name="biweekly-1" class="form-control">' +
                        '<option>Monday</option>' +
                        '<option>Tuesday</option>' +
                        '<option>Wednesday</option>' +
                        '<option>Thursday</option>' +
                        '<option>Friday</option>' +
                        '<option>Saturday</option>' +
                        '<option>Sunday</option>' +
                        '</select>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Second Payment</label>' +
                        '<select id="biweekly-2-period" name="biweekly-2" class="form-control">' +
                        '<option>Monday</option>' +
                        '<option>Tuesday</option>' +
                        '<option>Wednesday</option>' +
                        '<option>Thursday</option>' +
                        '<option>Friday</option>' +
                        '<option>Saturday</option>' +
                        '<option>Sunday</option>' +
                        '</select>' +
                        '</div>' +
                        '</div>';

                break;
            case 'monthly' :
                dropdown = '<label>Pay Day</label><select id="monthly-period" name="monthly" class="form-control">' +
                        '<option>1</option>' +
                        '<option>2</option>' +
                        '<option>3</option>' +
                        '<option>4</option>' +
                        '<option>5</option>' +
                        '<option>6</option>' +
                        '<option>7</option>' +
                        '<option>8</option>' +
                        '<option>9</option>' +
                        '<option>10</option>' +
                        '<option>11</option>' +
                        '<option>12</option>' +
                        '<option>13</option>' +
                        '<option>14</option>' +
                        '<option>15</option>' +
                        '<option>16</option>' +
                        '<option>17</option>' +
                        '<option>18</option>' +
                        '<option>19</option>' +
                        '<option>20</option>' +
                        '<option>21</option>' +
                        '<option>22</option>' +
                        '<option>23</option>' +
                        '<option>24</option>' +
                        '<option>25</option>' +
                        '<option>26</option>' +
                        '<option>27</option>' +
                        '<option>28</option>' +
                        '<option>29</option>' +
                        '<option>30</option>' +
                        '<option>31</option>' +
                        '</select>';

                break;

            case 'semi-monthly' :

                dropdown = '<div class="row">' +
                        '<div class="col-md-6">' +
                        '<label>First Payment</label>' +
                        '<select id="semi-monthly-1-period" name="semi-monthly-1" class="form-control">' +
                        '<option>1</option>' +
                        '<option>2</option>' +
                        '<option>3</option>' +
                        '<option>4</option>' +
                        '<option>5</option>' +
                        '<option>6</option>' +
                        '<option>7</option>' +
                        '<option>8</option>' +
                        '<option>9</option>' +
                        '<option>10</option>' +
                        '<option>11</option>' +
                        '<option>12</option>' +
                        '<option>13</option>' +
                        '<option>14</option>' +
                        '<option>15</option>' +
                        '<option>16</option>' +
                        '<option>17</option>' +
                        '<option>18</option>' +
                        '<option>19</option>' +
                        '<option>20</option>' +
                        '<option>21</option>' +
                        '<option>22</option>' +
                        '<option>23</option>' +
                        '<option>24</option>' +
                        '<option>25</option>' +
                        '<option>26</option>' +
                        '<option>27</option>' +
                        '<option>28</option>' +
                        '<option>29</option>' +
                        '<option>30</option>' +
                        '<option>31</option>' +
                        '</select>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Second Payment</label>' +
                        '<select id="semi-monthly-2-period" name="semi-monthly-2" class="form-control">' +
                        '<option>1</option>' +
                        '<option>2</option>' +
                        '<option>3</option>' +
                        '<option>4</option>' +
                        '<option>5</option>' +
                        '<option>6</option>' +
                        '<option>7</option>' +
                        '<option>8</option>' +
                        '<option>9</option>' +
                        '<option>10</option>' +
                        '<option>11</option>' +
                        '<option>12</option>' +
                        '<option>13</option>' +
                        '<option>14</option>' +
                        '<option>15</option>' +
                        '<option>16</option>' +
                        '<option>17</option>' +
                        '<option>18</option>' +
                        '<option>19</option>' +
                        '<option>20</option>' +
                        '<option>21</option>' +
                        '<option>22</option>' +
                        '<option>23</option>' +
                        '<option>24</option>' +
                        '<option>25</option>' +
                        '<option>26</option>' +
                        '<option>27</option>' +
                        '<option>28</option>' +
                        '<option>29</option>' +
                        '<option>30</option>' +
                        '<option>31</option>' +
                        '</select>' +
                        '</div>' +
                        '</div>';

                break;
        }


        $('#payday-container').html(dropdown);
    });
</script>