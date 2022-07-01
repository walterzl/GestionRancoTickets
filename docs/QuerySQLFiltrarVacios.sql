--select top 50 * from tm_ticket_oc order by tickoc_id desc
--select * from tm_ticket_oc_estOC

--SP_L_TICKETOC_02 '','','','','3','','',''

ALTER PROCEDURE SP_L_TICKETOC_02 
--declare
@tip_id			INT,        
@area_id		INT,
@tick_estado	VARCHAR(15),
@usu_asig_est	VARCHAR(2),          
@sis_id			INT,      
@estoc_id		VARCHAR(1),      
@tickoc_orden	VARCHAR(10),      
@fech_crea		VARCHAR(50)      
AS
--select  @tip_id='',@area_id='',@tick_estado='',@usu_asig_est='',@sis_id=3 ,@estoc_id='',@tickoc_orden='',@fech_crea=''
BEGIN            
 --declare @tip_id int            
 --declare @area_id int            
            
 --set @tip_id=1            
 --set @area_id=1            
            
 IF @tip_id = ''            
 SELECT @tip_id = NULL            
            
 IF @area_id = ''            
 SELECT @area_id = NULL            
            
 IF @tick_estado = ''            
 SELECT @tick_estado = NULL            
            
 IF @usu_asig_est = ''            
 SELECT @usu_asig_est = NULL           
       
 IF @fech_crea = ''            
 SELECT @fech_crea = NULL  
            
 SELECT 
 oc.tickoc_id,            
 oc.usu_id,            
 oc.cat_id,            
 oc.tickoc_titulo,            
 oc.tickoc_descrip,            
 oc.tickoc_estado,            
 oc.tickoc_prio,            
 oc.fech_cierre,            
 oc.fech_crea,            
 oc.tip_id,            
 u.usu_nom,            
 u.usu_ape,            
 c.cat_nom,            
 a.area_id,            
 a.area_nom,            
 oc.usu_asig,            
 oc.usu_asig_est,            
 s.suba_nom,          
 t.tip_nom,           
 oc.tickoc_corre,      
 ocest.tickoc_orden,      
 ocest.fech_dig,      
 ocest.fech_apro,      
 ocest.fech_envprov,      
 ocest.fech_repbode,      
 ocest.fech_rechbode,  
 ocest.estoc_id,      
 est.estoc_nom2,
 asig.usu_nom AS usu_nom_asig,            
 asig.usu_ape AS usu_ape_asig
 FROM            
  tm_ticket_oc oc           
  INNER JOIN tm_categoria c on oc.cat_id = c.cat_id            
  INNER JOIN tm_usuario u on oc.usu_id = u.usu_id 
  LEFT JOIN tm_usuario asig on oc.usu_asig = u.usu_id 
  INNER JOIN tm_area a on oc.area_id = a.area_id            
  INNER JOIN tm_subarea s on oc.suba_id = s.suba_id            
  INNER JOIN tm_tipo t ON oc.tip_id = t.tip_id      
  LEFT JOIN tm_ticket_oc_estOC ocest ON oc.tickoc_id = ocest.tickoc_id   
  LEFT JOIN tm_estado_oc est ON ocest.estoc_id = est.estoc_id  
 WHERE            
  oc.est = 1            
  AND oc.tip_id = ISNULL(@tip_id,oc.tip_id)            
  AND oc.area_id = ISNULL(@area_id,oc.area_id)            
  AND oc.tickoc_estado = ISNULL(@tick_estado,oc.tickoc_estado)            
  AND usu_asig_est = ISNULL(@usu_asig_est,usu_asig_est)  
  AND ISNULL(ocest.tickoc_orden,0) = (case when @tickoc_orden=0 then ISNULL(ocest.tickoc_orden,0) else @tickoc_orden end)
  AND ISNULL(ocest.estoc_id,0) = (case when @estoc_id=0 then ISNULL(ocest.estoc_id,0) else @estoc_id end)    
  AND convert(date,oc.fech_crea) = ISNULL(@fech_crea,oc.fech_crea)      
  AND oc.sis_id = @sis_id          
  ORDER BY oc.tickoc_id DESC            
END   





