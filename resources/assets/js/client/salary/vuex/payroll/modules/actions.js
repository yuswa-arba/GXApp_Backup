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

        state.attemptGenerateSalaryReport=[] //reset
        state.isFetchingAttemptSalaryReportData = true

        if(payload.generateSalaryReportLogId){

            commit({
                type:'getAttemptGenerateSalaryReport',
                generateSalaryReportLogId:payload.generateSalaryReportLogId
            })
        }
    },
    startGeneratePayroll({commit,state},payload){

// hide modal
        $('#modal-start-generate-payroll').modal('toggle')

        state.isStartGeneratingPayroll = true

        if(payload.generateSalaryReportLogId&&payload.transferDate&&payload.notes&&state.attemptGenerateType){

            commit({
                type:'generatePayroll',
                transferDate:payload.transferDate,
                generateSalaryReportLogId:payload.generateSalaryReportLogId,
                generateType:state.attemptGenerateType,
                notes:payload.notes
            })

        } else {
             $('.page-container').pgNotification({
                  style: 'flip',
                  message: 'An Error Occurred. Something is missing',
                  position: 'top-right',
                  timeout: 3500,
                  type: 'danger'
              }).show();
        }


    }
}