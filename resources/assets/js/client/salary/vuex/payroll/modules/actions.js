/**
 * Created by kevinpurwono on 8/12/17.
 */
import waterfall from 'async/waterfall';
import series from 'async/series';

export default{

    getDataOnCreate({commit, state}, payload){
        commit('getLastGeneratedPayroll')
        commit('getPayrollList')
    },
    getSalaryReportList({commit, state}, payload){
        commit({type:'getSalaryReportHistory',selectedYear:'',branchOfficeId:''})
    },
    attemptGetSalaryReportDetail({commit, state}, payload){

        //reset
        state.salaryReportDetails=[]
        state.isFetchingReportDetail = true

        //get data
        if(payload.id){
            commit({type: 'getSalaryReportDetail', id: payload.id})
        }

    },
    sortReportList({commit,state},payload){

        if(payload.selectedYear)
        state.selectedYear = payload.selectedYear

        if(payload.selectedBranchOfficeId)
        state.selectedBranchOfficeId = payload.selectedBranchOfficeId

        commit({
            type:'getSalaryReportHistory',
            selectedYear:state.selectedYear,
            branchOfficeId:state.selectedBranchOfficeId
        })
    },
    attemptGeneratePayroll({commit,state},payload){

        state.isFetchingAttemptSalaryReportDate = true

        if(payload.generateSalaryReportLogId){

            commit({
                type:'getAttemptGenerateSalaryReport',
                generateSalaryReportLogId:payload.generateSalaryReportLogId
            })

        }


    }
}