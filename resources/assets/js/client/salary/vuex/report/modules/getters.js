/**
 * Created by kevinpurwono on 8/12/17.
 */
export default{
    defaultFromDate(state){
        return state.defaultFromDate + '/' + (moment().month()+1) + '/' + moment().year()
    },
    defaultToDate(state){
        return state.defaultToDate + '/' + (moment().month()+1) + '/' + moment().year()
    }
}