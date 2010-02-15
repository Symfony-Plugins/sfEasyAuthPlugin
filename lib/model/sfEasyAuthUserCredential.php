<?php

class sfEasyAuthUserCredential extends BasesfEasyAuthUserCredential
{
  /**
   * Deletes profiles that are related with a credential when the 
   * credential is deleted
   * 
   * @param PropelPDO $con 
   */
  public function delete(PropelPDO $con = null)
  {
    if ($this->getProfileId() !== null)
    {
      // retrieve the associated user
      if ($eaUser = sfEasyAuthUserPeer::retrieveByPK($this->getUserId()))
      {
        // try to retrive the profile
        $getter = sfEasyAuthUser::getProfileGetter($this->getCredential());
        if ($profile = $eaUser->{$getter}())
        {
          $profile->delete();
        }
      }
    }

    return parent::delete($con);
  }
}
