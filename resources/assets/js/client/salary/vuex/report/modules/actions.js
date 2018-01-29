/**
 * Created by kevinpurwono on 8/12/17.
 */
import waterfall from 'async/waterfall';
import series from 'async/series';

export default{

    getDataOnCreate({commit, state}){

        commit({type: 'getBranchOffices'})
        commit({type: 'getGeneratedSalaryLogs'})
        commit({type: 'getDefaultGenerateDate'})
    },

    attemptGenerateSalaryData({commit, state}, payload){

        //reset the first time
        state.attemptGenerateSalaryData = []
        state.salaryQueues = []
        state.isFetchingSalaryData = true

        if(payload.fromDate && payload.toDate && payload.branchOfficeId){

            commit({
                type: 'getAttemptGenerateSalaryData',
                fromDate:payload.fromDate,
                toDate:payload.toDate,
                branchOfficeId:payload.branchOfficeId
            })

            commit({
                type:'getSalaryQueues',
                branchOfficeId:payload.branchOfficeId
            })


        } else {
            $('.page-container').pgNotification({
                style: 'flip',
                message: 'An Error Occurred. Required param missing',
                position: 'top-right',
                timeout: 3500,
                type: 'danger'
            }).show();
        }

    },

    generateSalary({commit,state},payload){

        state.isGeneratingSalary = true

        if(payload.fromDate && payload.toDate && payload.branchOfficeId){
            commit({
                type: 'generateSalaryNow',
                fromDate:payload.fromDate,
                toDate:payload.toDate,
                branchOfficeId:payload.branchOfficeId
            })
        } else {
            $('.page-container').pgNotification({
                style: 'flip',
                message: 'An Error Occurred. Required param missing',
                position: 'top-right',
                timeout: 3500,
                type: 'danger'
            }).show();
        }

    }

}