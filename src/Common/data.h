#ifndef __DEVICE_TYPE__
    #define __DEVICE_TYPE__
    typedef enum _devices {
        CAM_AI = 0,
        CONTROLLER = 1,
        GSHEET = 2
    } Device;
#endif


#ifndef __DATA_STRUCTURE__
    #define __DATA_STRUCTURE__
    typedef struct _datas {
        int x;
        int y;
        int p_val;
        Device device;
    } BSData;
#endif


