/**
 * Created by kevinpurwono on 8/12/17.
 */

import getters from'./getters'
import mutations from './mutations'
import actions from './actions'

export default {
    namespaced: true,
    state: {
        salaryReportsHistory:[],
        lastGeneratedPayroll:{},
        generatedPayrollList:[],
        salaryReportDetails:[],
        isFetchingReportDetail:false,
        selectedYear:'',
        selectedBranchOfficeId:'',
        attemptGenerateSalaryReport:[],
        isFetchingAttemptSalaryReportData:false,
        isStartGeneratingPayroll:false,
        attemptGenerateType:'',
        generatePayrollResponse:{isFailed:false,message:''},
        generatedPayrollId:''
    },
    getters,
    mutations,
    actions
}