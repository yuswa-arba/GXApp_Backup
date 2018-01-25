/**
 * Created by kevinpurwono on 8/12/17.
 */
import {get, post} from '../../../../helpers/api'
import {api_path} from '../../../../helpers/const'
import series from 'async/series';
export default{
    getSalayReportHistory(state, payload){

        get(api_path + 'salary/payroll/generateSalary/history')
            .then((res) => {

                if (!res.data.isFailed) {
                    state.salaryReportsHistory = res.data.reports
                }

            })
            .catch((err) => {
                $('.page-container').pgNotification({
                    style: 'flip',
                    message: err.message,
                    position: 'top-right',
                    timeout: 3500,
                    type: 'danger'
                }).show();
            })
    }

}